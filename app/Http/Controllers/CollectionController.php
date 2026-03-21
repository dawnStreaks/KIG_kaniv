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
        
        if ($request->filled('status')) {
            $query->where('collection_status', $request->status);
        }
        
        $totalAmount = $query->sum('amount');
        $collections = $query->latest()->paginate(10)->appends($request->query());
        
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
            
        $allUsers = Collection::with('enteredBy')
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
            ->get()->pluck('enteredBy.name')->unique()->filter()->sort()->values();
        
        return view('collections.index', compact('collections', 'totalAmount', 'allUnits', 'allTerms', 'allTypes', 'allUsers'));
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
        if ($collection->collection_status !== 'payable') {
            abort(403, 'Only payable collections can be edited');
        }
        
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
        if ($collection->collection_status !== 'payable') {
            abort(403, 'Only payable collections can be edited');
        }
        
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
        
        $terms = CollectionTerm::active()->pluck('name');
        $types = CollectionType::active()->pluck('name');
        
        return view('collections.report', compact('year', 'user', 'data', 'dateFrom', 'dateTo', 'terms', 'types'));
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

    public function receiveCollections(Request $request)
    {
        if (!auth()->user()->isMekhalaUser()) {
            abort(403, 'Only mekhala users can access this page');
        }

        $query = Collection::with(['unit.area', 'enteredBy'])
            ->whereHas('unit.area', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });

        // Apply filters
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
        
        if ($request->filled('area')) {
            $query->whereHas('unit.area', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->area . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('collection_status', $request->status);
        }

        $collections = $query->latest()->paginate(10)->appends($request->query());
        
        // Get dropdown options for mekhala users
        $units = \App\Models\Unit::whereHas('area', function($q) {
            $q->where('mekhala_id', auth()->user()->mekhala_id);
        })->pluck('name', 'name')->sort();
        
        $areas = \App\Models\Area::where('mekhala_id', auth()->user()->mekhala_id)
            ->pluck('name', 'name')->sort();
        
        $types = \App\Models\Collection::whereHas('unit.area', function($q) {
            $q->where('mekhala_id', auth()->user()->mekhala_id);
        })->pluck('type')->unique()->filter()->sort()->values();
        
        $terms = \App\Models\Collection::whereHas('unit.area', function($q) {
            $q->where('mekhala_id', auth()->user()->mekhala_id);
        })->pluck('term')->unique()->filter()->sort()->values();
        
        return view('collections.receive', compact('collections', 'units', 'areas', 'types', 'terms'));
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
        return back()->with('success', 'Collection marked as mekhala received');
    }

    public function centerReceiveCollections(Request $request)
    {
        if (!auth()->user()->isCenterUser()) {
            abort(403, 'Only center users can access this page');
        }

        // Show collections that are forwarded to center or already center received
        $query = Collection::with(['unit.area.mekhala', 'enteredBy'])
            ->whereIn('collection_status', ['forwarded', 'center_received']);

        // Apply filters
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
        
        if ($request->filled('area')) {
            $query->whereHas('unit.area', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->area . '%');
            });
        }
        
        if ($request->filled('mekhala')) {
            $query->whereHas('unit.area.mekhala', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->mekhala . '%');
            });
        }
        
        if ($request->filled('user')) {
            $query->whereHas('enteredBy', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('collection_status', $request->status);
        }

        $collections = $query->orderByRaw("FIELD(collection_status, 'forwarded', 'center_received')")->latest('collection_date')->paginate(10)->appends($request->query());
        $totalAmount = $query->sum('amount');
        
        // Get dropdown options
        $units = \App\Models\Unit::whereHas('collections', function($q) {
            $q->whereIn('collection_status', ['forwarded', 'center_received']);
        })->pluck('name', 'name')->sort();
        
        $areas = \App\Models\Area::whereHas('units.collections', function($q) {
            $q->whereIn('collection_status', ['forwarded', 'center_received']);
        })->pluck('name', 'name')->sort();
        
        $mekhalas = \App\Models\Mekhala::whereHas('areas.units.collections', function($q) {
            $q->whereIn('collection_status', ['forwarded', 'center_received']);
        })->pluck('name', 'name')->sort();
        
        $users = \App\Models\User::whereHas('collections', function($q) {
            $q->whereIn('collection_status', ['forwarded', 'center_received']);
        })->pluck('name', 'name')->sort();
        
        $types = \App\Models\Collection::whereIn('collection_status', ['forwarded', 'center_received'])
            ->pluck('type')->unique()->filter()->sort()->values();
            
        $terms = \App\Models\Collection::whereIn('collection_status', ['forwarded', 'center_received'])
            ->pluck('term')->unique()->filter()->sort()->values();
        
        return view('collections.center-receive', compact('collections', 'totalAmount', 'units', 'areas', 'mekhalas', 'users', 'types', 'terms'));
    }

    public function markAsCenterReceived(Collection $collection)
    {
        if (!auth()->user()->isCenterUser()) {
            abort(403, 'Only center users can receive collections');
        }

        if ($collection->collection_status !== 'forwarded') {
            abort(403, 'Collection must be forwarded to center first');
        }

        $collection->update(['collection_status' => 'center_received']);
        return back()->with('success', 'Collection marked as center received');
    }

    public function reverseCenterReceived(Collection $collection)
    {
        if (!auth()->user()->isCenterUser()) {
            abort(403, 'Only center users can reverse center received collections');
        }

        if ($collection->collection_status !== 'center_received') {
            abort(403, 'Collection must be center received to reverse');
        }

        $collection->update(['collection_status' => 'payable']);
        return back()->with('success', 'Collection returned to mekhala as payable');
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

        return back()->with('success', "$count collections marked as mekhala received");
    }

    public function unitTypeComparison(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $term = $request->get('term');
        $type = $request->get('type');
        $user = auth()->user();
        
        $query = \App\Models\Unit::with(['collections' => function($q) use ($year, $term, $type) {
            $q->whereYear('collection_date', $year);
            if ($term) {
                $q->where('term', $term);
            }
            if ($type) {
                $q->where('type', $type);
            }
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
        ->map(function($units, $unitType) {
            $total = $units->sum(function($unit) {
                return $unit->collections->sum('amount');
            });
            // Only count units that have collections matching the filters
            $unitsWithCollections = $units->filter(function($unit) {
                return $unit->collections->sum('amount') > 0;
            });
            return [
                'type' => $unitType,
                'total' => $total,
                'count' => $unitsWithCollections->count()
            ];
        })->filter(function($item) {
            return $item['total'] > 0; // Only show unit types with collections
        })->values();
        
        // Get filter options
        $terms = \App\Models\CollectionTerm::active()->pluck('name')->toArray();
        $types = \App\Models\CollectionType::active()->pluck('name')->toArray();
        
        return view('collections.unit-type-comparison', compact('data', 'year', 'term', 'type', 'terms', 'types'));
    }

    public function unitTypeDrillDown(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $unitType = $request->get('type');
        $term = $request->get('term');
        $collectionType = $request->get('collection_type');
        $user = auth()->user();
        
        $query = \App\Models\Unit::with(['collections' => function($q) use ($year, $term, $collectionType) {
            $q->whereYear('collection_date', $year);
            if ($term) {
                $q->where('term', $term);
            }
            if ($collectionType) {
                $q->where('type', $collectionType);
            }
        }, 'area']);
        
        // Filter by mekhala for mekhala users
        if ($user->isMekhalaUser()) {
            $query->whereHas('area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        
        // Filter by unit type
        if ($unitType === 'YI') {
            $query->where('name', 'like', 'YI%');
        } elseif ($unitType === 'IWA') {
            $query->where('name', 'like', 'IWA%');
        } else {
            $query->where('name', 'not like', 'YI%')
                  ->where('name', 'not like', 'IWA%');
        }
        
        $units = $query->get()->map(function($unit) {
            $totalAmount = $unit->collections->sum('amount');
            $collectionCount = $unit->collections->count();
            
            return [
                'unit_name' => $unit->name,
                'area_name' => $unit->area->name ?? 'N/A',
                'total_amount' => $totalAmount,
                'collection_count' => $collectionCount
            ];
        })->filter(function($unit) {
            return $unit['total_amount'] > 0 || $unit['collection_count'] > 0;
        })->sortByDesc('total_amount')->values();
        
        return response()->json($units);
    }
}