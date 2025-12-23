<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Collection;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $query = Investment::with(['creator']);
        
        // Filter by user's mekhala if they are a mekhala user
        if (auth()->user()->isMekhalaUser()) {
            $query->whereHas('creator', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id);
            });
        }
        
        $investments = $query->latest()->paginate(10);
        return view('investments.index', compact('investments'));
    }

    public function create()
    {
        if (!auth()->user()->canAddInvestments()) {
            abort(403, 'Access denied.');
        }
        
        $user = auth()->user();
        $currentYear = date('Y');
        
        // Calculate net balance based on mekhala
        $collectionsQuery = Collection::received()->whereYear('collection_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $collectionsQuery->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyCollections = $collectionsQuery->sum('amount');
        
        $expensesQuery = \App\Models\Expense::whereYear('expense_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $expensesQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyExpenses = $expensesQuery->sum('amount');
        
        $applicationsQuery = \App\Models\Application::where('status', 'paid')->whereYear('approved_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $applicationsQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyApplications = $applicationsQuery->sum('approved_amount');
        
        $investmentsQuery = Investment::whereYear('investment_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $investmentsQuery->whereHas('creator', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyInvestments = $investmentsQuery->sum('amount');
        
        $returnedQuery = Investment::whereYear('investment_date', $currentYear);
        if ($user->isMekhalaUser()) {
            $returnedQuery->whereHas('creator', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyReturned = $returnedQuery->sum('returned_amount');
        
        $investedAmount = $yearlyInvestments - $yearlyReturned;
        $availableAmount = $yearlyCollections - $yearlyExpenses - $yearlyApplications - $investedAmount;
        
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
            'income_generated' => $investment->income_generated + $request->income,
            'status' => 'income_generated'
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