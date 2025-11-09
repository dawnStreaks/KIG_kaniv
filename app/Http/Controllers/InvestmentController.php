<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Collection;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['creator', 'approver'])->latest()->paginate(10);
        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        $totalCollections = Collection::sum('amount');
        $totalInvestments = Investment::sum('amount');
        $availableAmount = $totalCollections - $totalInvestments;
        
        return view('investments.create', compact('availableAmount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'investment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000'
        ]);

        $validated['created_by'] = auth()->id();
        Investment::create($validated);
        
        return redirect()->route('investments.index')->with('success', 'Investment created successfully');
    }

    public function addIncome(Request $request, Investment $investment)
    {
        $request->validate(['income' => 'required|numeric|min:0']);
        
        $investment->update([
            'income_generated' => $investment->income_generated + $request->income
        ]);
        
        return redirect()->route('investments.index')->with('success', 'Income added successfully');
    }

    public function approve(Investment $investment)
    {
        $investment->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);
        
        return redirect()->route('investments.index')->with('success', 'Investment approved successfully');
    }

    public function returnCapital(Request $request, Investment $investment)
    {
        $request->validate(['returned_amount' => 'required|numeric|min:0']);
        
        $newReturnedAmount = ($investment->returned_amount ?? 0) + $request->returned_amount;
        
        $investment->update([
            'returned_amount' => $newReturnedAmount
        ]);
        
        return redirect()->route('investments.index')->with('success', 'Capital return recorded successfully');
    }
}