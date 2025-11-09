<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Unit;
use App\Models\Area;
use App\Models\CollectionTerm;
use App\Models\CollectionType;
use Illuminate\Http\Request;
use App\Exports\CollectionsExport;
use Maatwebsite\Excel\Facades\Excel;

class CollectionController extends Controller
{
    public function index()
    {
        $query = Collection::with(['unit.area', 'enteredBy']);
        
        if (auth()->user()->isAreaUser()) {
            $query->whereHas('unit', function($q) {
                $q->where('area_id', auth()->user()->area_id);
            });
        }
        
        $collections = $query->latest()->paginate(10);
        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $units = auth()->user()->isAreaUser() 
            ? Unit::where('area_id', auth()->user()->area_id)->get()
            : Unit::with('area')->get();
            
        $terms = CollectionTerm::active()->pluck('name')->toArray();
        $types = CollectionType::active()->pluck('name')->toArray();
            
        return view('collections.create', compact('units', 'terms', 'types'));
    }

    public function store(Request $request)
    {
        // Handle bulk collections for area users
        if ($request->has('selected_units')) {
            $request->validate([
                'collection_date' => 'required|date',
                'type' => 'required|string',
                'term' => 'required|string',
                'selected_units' => 'required|array',
                'selected_units.*' => 'exists:units,id',
            ]);

            $created = 0;
            foreach ($request->selected_units as $unitId) {
                if ($request->amount[$unitId] && $request->amount[$unitId] > 0) {
                    Collection::create([
                        'unit_id' => $unitId,
                        'amount' => $request->amount[$unitId],
                        'collection_date' => $request->collection_date,
                        'type' => $request->type,
                        'term' => $request->term,
                        'notes' => $request->notes,
                        'entered_by' => auth()->id(),
                    ]);
                    $created++;
                }
            }
            
            return redirect()->route('collections.index')->with('success', "$created collection entries added successfully");
        }
        
        // Handle single collection for other users
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'collection_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $validated['entered_by'] = auth()->id();
        Collection::create($validated);
        
        return redirect()->route('collections.index')->with('success', 'Collection entry added successfully');
    }

    public function show(Collection $collection)
    {
        return view('collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $units = auth()->user()->isAreaUser() 
            ? Unit::where('area_id', auth()->user()->area_id)->active()->get()
            : Unit::with('area')->active()->get();
            
        $terms = CollectionTerm::active()->pluck('name')->toArray();
        $types = CollectionType::active()->pluck('name')->toArray();
            
        return view('collections.edit', compact('collection', 'units', 'terms', 'types'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'collection_date' => 'required|date',
            'type' => 'required|string',
            'term' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $collection->update($validated);
        return redirect()->route('collections.index')->with('success', 'Collection updated successfully');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted successfully');
    }

    public function unitCollections()
    {
        $areas = Area::with(['units.collections'])->active()->get();
        return view('collections.unit-collections', compact('areas'));
    }

    public function areaCollections(Request $request)
    {
        $area = Area::with(['units.collections' => function($query) {
            $query->with('enteredBy');
        }])->findOrFail($request->area_id);
        
        $totalAmount = $area->units->sum(function($unit) {
            return $unit->collections->sum('amount');
        });
        
        return view('collections.area-collections', compact('area', 'totalAmount'));
    }

    public function collectionReport(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $user = auth()->user();
        
        $query = Collection::with(['unit.area'])
            ->whereYear('collection_date', $year);
        
        if ($user->isAreaUser()) {
            $query->whereHas('unit', function($q) use ($user) {
                $q->where('area_id', $user->area_id);
            });
            
            $data = $query->selectRaw('units.name as unit_name, SUM(amount) as total_amount')
                ->join('units', 'collections.unit_id', '=', 'units.id')
                ->groupBy('units.id', 'units.name')
                ->get();
        } else {
            $data = $query->selectRaw('areas.id as area_id, areas.name as area_name, SUM(amount) as total_amount')
                ->join('units', 'collections.unit_id', '=', 'units.id')
                ->join('areas', 'units.area_id', '=', 'areas.id')
                ->groupBy('areas.id', 'areas.name')
                ->get();
        }
        
        return view('collections.report', compact('year', 'user', 'data'));
    }

    public function collectionReportDrillDown(Request $request)
    {
        $areaId = $request->get('area_id');
        $year = $request->get('year', date('Y'));
        
        $data = Collection::with(['unit'])
            ->whereYear('collection_date', $year)
            ->whereHas('unit', function($q) use ($areaId) {
                $q->where('area_id', $areaId);
            })
            ->selectRaw('units.name as unit_name, SUM(amount) as total_amount')
            ->join('units', 'collections.unit_id', '=', 'units.id')
            ->groupBy('units.id', 'units.name')
            ->get();
            
        return response()->json($data);
    }

    public function export(Request $request)
    {
        return Excel::download(new CollectionsExport($request), 'collections.xlsx');
    }
}