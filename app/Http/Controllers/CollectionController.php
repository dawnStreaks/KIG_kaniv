<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Unit;
use App\Models\Area;
use Illuminate\Http\Request;

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
            ? Unit::where('area_id', auth()->user()->area_id)->active()->get()
            : Unit::with('area')->active()->get();
            
        return view('collections.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'collection_date' => 'required|date',
            'notes' => 'nullable|string',
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
}