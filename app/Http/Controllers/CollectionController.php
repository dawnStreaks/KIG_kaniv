<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Unit;
use App\Models\Area;
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
            
        // Get terms and types from session (managed by center/admin users)
        $terms = session('collection_terms', ['Monthly', 'Quarterly', 'Yearly', 'One-time']);
        $types = session('collection_types', ['Regular', 'Special', 'Emergency', 'Donation']);
            
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
            
        return view('collections.edit', compact('collection', 'units'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'collection_date' => 'required|date',
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

    public function export(Request $request)
    {
        return Excel::download(new CollectionsExport($request), 'collections.xlsx');
    }
}