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
        
        // Filter by user type and role
        if (auth()->user()->isCenterUser()) {
            // Center users see only investments created by center users
            $query->whereHas('creator', function($q) {
                $q->where('user_type', 'center');
            });
        } elseif (auth()->user()->isMekhalaUser()) {
            // Mekhala users see only investments from their mekhala, excluding center investments
            $query->whereHas('creator', function($q) {
                $q->where('mekhala_id', auth()->user()->mekhala_id)
                  ->where('user_type', '!=', 'center');
            });
        }
        // Admin users see all investments (no filter applied)
        
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
        
        // Calculate net balance based on user type
        $collectionsQuery = Collection::received()->whereYear('collection_date', $currentYear);
        if ($user->isCenterUser()) {
            $collectionsQuery = Collection::centerReceived()->whereYear('collection_date', $currentYear);
        } elseif ($user->isMekhalaUser()) {
            $collectionsQuery->whereHas('unit.area', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyCollections = $collectionsQuery->sum('amount');
        
        $expensesQuery = \App\Models\Expense::whereYear('expense_date', $currentYear);
        if ($user->isCenterUser()) {
            $expensesQuery->whereHas('enteredBy', function($q) {
                $q->where('user_type', 'center');
            });
        } elseif ($user->isMekhalaUser()) {
            $expensesQuery->whereHas('enteredBy', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyExpenses = $expensesQuery->sum('amount');
        
        $applicationsQuery = \App\Models\Application::where('status', 'paid')->whereYear('approved_date', $currentYear);
        if ($user->isCenterUser()) {
            // Center users don't have applications, set to 0
            $yearlyApplications = 0;
        } elseif ($user->isMekhalaUser()) {
            $applicationsQuery->whereHas('submitter', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
            $yearlyApplications = $applicationsQuery->sum('approved_amount');
        } else {
            $yearlyApplications = $applicationsQuery->sum('approved_amount');
        }
        
        $investmentsQuery = Investment::whereYear('investment_date', $currentYear);
        if ($user->isCenterUser()) {
            $investmentsQuery->whereHas('creator', function($q) {
                $q->where('user_type', 'center');
            });
        } elseif ($user->isMekhalaUser()) {
            $investmentsQuery->whereHas('creator', function($q) use ($user) {
                $q->where('mekhala_id', $user->mekhala_id);
            });
        }
        $yearlyInvestments = $investmentsQuery->sum('amount');
        
        $returnedQuery = Investment::whereYear('investment_date', $currentYear);
        if ($user->isCenterUser()) {
            $returnedQuery->whereHas('creator', function($q) {
                $q->where('user_type', 'center');
            });
        } elseif ($user->isMekhalaUser()) {
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
        
        // Check if user can access this investment
        if (auth()->user()->isCenterUser() && $investment->creator->user_type !== 'center') {
            abort(403, 'Access denied.');
        }
        
        if (auth()->user()->isMekhalaUser() && ($investment->creator->mekhala_id !== auth()->user()->mekhala_id || $investment->creator->user_type === 'center')) {
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
        
        // Check if user can access this investment
        if (auth()->user()->isCenterUser() && $investment->creator->user_type !== 'center') {
            abort(403, 'Access denied.');
        }
        
        if (auth()->user()->isMekhalaUser() && ($investment->creator->mekhala_id !== auth()->user()->mekhala_id || $investment->creator->user_type === 'center')) {
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