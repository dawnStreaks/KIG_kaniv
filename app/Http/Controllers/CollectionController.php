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
    public function index(Request $request)
    {
        $query = Collection::with(['unit.area', 'enteredBy']);
        
        if (auth()->user()->isAreaUser()) {
            $query->whereHas('unit', function($q) {
                $q->where('area_id', auth()->user()->area_id);
            });
        } elseif (auth()->user()->isMekhalaUser()) {
            $query->whereHas('unit.area', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });
        }
        
        if ($request->filled('amount')) {
            $query->where('amount', 'like', '%' . $request->amount . '%');
        }
        
        if ($request->filled('collection_date')) {
            $query->whereDate('collection_date', $request->collection_date);
        }
        
        if ($request->filled('unit')) {
            $query->whereHas('unit', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->unit . '%');
            });
        }
        
        if ($request->filled('term')) {
            $query->where('term', 'like', '%' . $request->term . '%');
        }
        
        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('collection_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('collection_date', '<=', $request->date_to);
        }
        
        if ($request->filled('user')) {
            $query->whereHas('enteredBy', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }
        
        $collections = $query->latest()->paginate(10)->appends($request->query());
        $totalAmount = $query->sum('amount');
        
        // Get all unique values for dropdowns (across all pages)
        $allUnits = Collection::with('unit')
            ->when(auth()->user()->isAreaUser(), function($q) {
                $q->whereHas('unit', function($subQ) {
                    $subQ->where('area_id', auth()->user()->area_id);
                });
            })
            ->when(auth()->user()->isMekhalaUser(), function($q) {
                $q->whereHas('unit.area', function($subQ) {
                    $subQ->where('mekhala_id', auth()->user()->mekhala_id);
                });
            })
            ->get()->pluck('unit.name')->unique()->filter()->sort()->values();
            
        $allTerms = Collection::when(auth()->user()->isAreaUser(), function($q) {
                $q->whereHas('unit', function($subQ) {
                    $subQ->where('area_id', auth()->user()->area_id);
                });
            })
            ->when(auth()->user()->isMekhalaUser(), function($q) {
                $q->whereHas('unit.area', function($subQ) {
                    $subQ->where('mekhala_id', auth()->user()->mekhala_id);
                });
            })
            ->pluck('term')->unique()->filter()->sort()->values();
            
        $allTypes = Collection::when(auth()->user()->isAreaUser(), function($q) {
                $q->whereHas('unit', function($subQ) {
                    $subQ->where('area_id', auth()->user()->area_id);
                });
            })
            ->when(auth()->user()->isMekhalaUser(), function($q) {
                $q->whereHas('unit.area', function($subQ) {
                    $subQ->where('mekhala_id', auth()->user()->mekhala_id);
                });
            })
            ->pluck('type')->unique()->filter()->sort()->values();
        
        return view('collections.index', compact('collections', 'totalAmount', 'allUnits', 'allTerms', 'allTypes'));
    }

    public function create()
    {
        if (auth()->user()->isAreaUser()) {
            $units = Unit::where('area_id', auth()->user()->area_id)->get();
        } elseif (auth()->user()->isMekhalaUser()) {
            $units = auth()->user()->getMekhalaUnitsQuery()->with('area')->get();
        } else {
            $units = Unit::with('area')->get();
        }
            
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
        if (auth()->user()->isAreaUser()) {
            $units = Unit::where('area_id', auth()->user()->area_id)->active()->get();
        } elseif (auth()->user()->isMekhalaUser()) {
            $units = auth()->user()->getMekhalaUnitsQuery()->active()->with('area')->get();
        } else {
            $units = Unit::with('area')->active()->get();
        }
            
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
        $dateFrom = $request->get('date_from', $year . '-01-01');
        $dateTo = $request->get('date_to', $year . '-12-31');
        $user = auth()->user();
        
        $query = Collection::with(['unit.area'])
            ->whereBetween('collection_date', [$dateFrom, $dateTo]);
            
        // Apply term filter
        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }
        
        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($user->isAreaUser()) {
            $query->whereHas('unit', function($q) use ($user) {
                $q->where('area_id', $user->area_id);
            });
            
            $data = $query->selectRaw('units.name as unit_name, SUM(amount) as total_amount')
                ->join('units', 'collections.unit_id', '=', 'units.id')
                ->groupBy('units.id', 'units.name')
                ->get();
        } elseif ($user->isMekhalaUser()) {
            $query->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
            
            $data = $query->selectRaw('areas.id as area_id, areas.name as area_name, SUM(amount) as total_amount')
                ->join('units', 'collections.unit_id', '=', 'units.id')
                ->join('areas', 'units.area_id', '=', 'areas.id')
                ->groupBy('areas.id', 'areas.name')
                ->get();
        } else {
            $data = $query->selectRaw('areas.id as area_id, areas.name as area_name, SUM(amount) as total_amount')
                ->join('units', 'collections.unit_id', '=', 'units.id')
                ->join('areas', 'units.area_id', '=', 'areas.id')
                ->groupBy('areas.id', 'areas.name')
                ->get();
        }
        
        return view('collections.report', compact('year', 'user', 'data', 'dateFrom', 'dateTo'));
    }

    public function collectionReportDrillDown(Request $request)
    {
        $areaId = $request->get('area_id');
        $dateFrom = $request->get('date_from', date('Y') . '-01-01');
        $dateTo = $request->get('date_to', date('Y') . '-12-31');
        $user = auth()->user();
        
        $query = Collection::with(['unit'])
            ->whereBetween('collection_date', [$dateFrom, $dateTo])
            ->whereHas('unit', function($q) use ($areaId) {
                $q->where('area_id', $areaId);
            });
            
        // Apply term filter
        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }
        
        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
            
        // Restrict mekhala users to their own mekhala areas only
        if ($user->isMekhalaUser()) {
            $query->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
        $data = $query->selectRaw('units.name as unit_name, SUM(amount) as total_amount')
            ->join('units', 'collections.unit_id', '=', 'units.id')
            ->groupBy('units.id', 'units.name')
            ->get();
            
        return response()->json($data);
    }

    public function export(Request $request)
    {
        return Excel::download(new CollectionsExport($request), 'collections.xlsx');
    }

    public function receiveCollections()
    {
        if (!auth()->user()->isMekhalaUser()) {
            abort(403, 'Only mekhala users can access this page');
        }

        $query = Collection::with(['unit.area', 'enteredBy'])
            ->whereHas('unit.area', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });

        $collections = $query->latest()->paginate(10);
        return view('collections.receive', compact('collections'));
    }

    public function markAsReceived(Collection $collection)
    {
        if (!auth()->user()->isMekhalaUser()) {
            abort(403, 'Only mekhala users can receive collections');
        }

        if ($collection->unit->area->mekhala_id !== auth()->user()->mekhala_id) {
            abort(403, 'You can only receive collections from your mekhala');
        }

        $collection->update(['collection_status' => 'received']);
        return back()->with('success', 'Collection marked as received');
    }

    public function centerReceiveCollections()
    {
        if (!auth()->user()->isCenterUser()) {
            abort(403, 'Only center users can access this page');
        }

        // Only show collections that were received by mekhala (forwarded to center)
        $query = Collection::with(['unit.area.mekhala', 'enteredBy'])
            ->where('collection_status', 'received'); // Only mekhala-received collections

        $collections = $query->latest()->paginate(10);
        return view('collections.center-receive', compact('collections'));
    }

    public function markAsCenterReceived(Collection $collection)
    {
        if (!auth()->user()->isCenterUser()) {
            abort(403, 'Only center users can receive collections');
        }

        if ($collection->collection_status !== 'received') {
            abort(403, 'Collection must be received by mekhala first');
        }

        $collection->update(['collection_status' => 'center_received']);
        return back()->with('success', 'Collection marked as center received');
    }

    public function forwardToCenter(Collection $collection)
    {
        if (!auth()->user()->isMekhalaUser()) {
            abort(403, 'Only mekhala users can forward collections');
        }

        if ($collection->unit->area->mekhala_id !== auth()->user()->mekhala_id) {
            abort(403, 'You can only forward collections from your mekhala');
        }

        if ($collection->collection_status !== 'received') {
            abort(403, 'Only received collections can be forwarded');
        }

        $collection->update(['collection_status' => 'forwarded']);
        return back()->with('success', 'Collection forwarded to center');
    }

    public function bulkReceive(Request $request)
    {
        if (!auth()->user()->isMekhalaUser()) {
            abort(403, 'Only mekhala users can receive collections');
        }

        $request->validate([
            'collection_ids' => 'required|array',
            'collection_ids.*' => 'exists:collections,id'
        ]);

        $collections = Collection::whereIn('id', $request->collection_ids)
            ->whereHas('unit.area', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            })
            ->where('collection_status', 'payable')
            ->get();

        $count = $collections->count();
        $collections->each(function($collection) {
            $collection->update(['collection_status' => 'received']);
        });

        return back()->with('success', "$count collections marked as received");
    }

    public function unitTypeComparison(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $user = auth()->user();
        
        $query = \App\Models\Unit::with(['collections' => function($q) use ($year) {
            $q->whereYear('collection_date', $year);
        }]);
        
        // Filter by mekhala for mekhala users
        if ($user->isMekhalaUser()) {
            $query->whereHas('area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
        $data = $query->get()
        ->groupBy(function($unit) {
            if (str_starts_with($unit->name, 'YI')) return 'YI';
            if (str_starts_with($unit->name, 'IWA')) return 'IWA';
            return 'KIG';
        })
        ->map(function($units, $type) {
            $total = $units->sum(function($unit) {
                return $unit->collections->sum('amount');
            });
            return [
                'type' => $type,
                'total' => $total,
                'count' => $units->count()
            ];
        })->values();
        
        return view('collections.unit-type-comparison', compact('data', 'year'));
    }
}