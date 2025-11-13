<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Collection;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['creator'])->latest()->paginate(10);
        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        if (!auth()->user()->canAddInvestments()) {
            abort(403, 'Access denied.');
        }
        
        $totalCollections = Collection::sum('amount');
        $totalInvestments = Investment::sum('amount');
        $availableAmount = $totalCollections - $totalInvestments;
        
        return view('investments.create', compact('availableAmount'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canAddInvestments()) {
            abort(403, 'Access denied.');
        }
        
        $validated = $request->validate([
            'investment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'invested';
        Investment::create($validated);
        
        return redirect()->route('investments.index')->with('success', 'Investment created successfully');
    }

    public function addIncome(Request $request, Investment $investment)
    {
        if (!auth()->user()->canAddInvestments()) {
            abort(403, 'Access denied.');
        }
        
        $request->validate(['income' => 'required|numeric|min:0']);
        
        $investment->update([
            'income_generated' => $investment->income_generated + $request->income
        ]);
        
        return redirect()->route('investments.index')->with('success', 'Income added successfully');
    }



    public function returnCapital(Request $request, Investment $investment)
    {
        if (!auth()->user()->canAddInvestments()) {
            abort(403, 'Access denied.');
        }
        
        $request->validate(['returned_amount' => 'required|numeric|min:0']);
        
        $investment->update([
            'status' => 'capital_returned',
            'returned_amount' => $request->returned_amount
        ]);
        
        return redirect()->route('investments.index')->with('success', 'Capital return recorded successfully');
    }
}