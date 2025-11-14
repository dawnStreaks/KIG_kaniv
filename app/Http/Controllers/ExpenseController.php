<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Exports\ExpensesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['application', 'enteredBy']);
        
        // Filter by mekhala for mekhala users
        if (auth()->user()->isMekhalaUser()) {
            $query->where('entered_by', auth()->id());
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('expense_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('expense_date', '<=', $request->date_to);
        }
        
        $expenses = $query->latest('expense_date')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        if (!auth()->user()->canAddExpenses()) {
            abort(403, 'Only treasurers can add expenses');
        }
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canAddExpenses()) {
            abort(403, 'Only treasurers can add expenses');
        }

        $validated = $request->validate([
            'expense_date' => 'required|date',
            'particulars' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:refreshment,miscellaneous',
            'bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bill')) {
            $validated['bill_path'] = $request->file('bill')->store('bills', 'public');
        }

        $validated['entered_by'] = auth()->id();
        Expense::create($validated);
        
        return redirect()->route('expenses.index')->with('success', 'Expense added successfully');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $applications = Application::approved()->get();
        return view('expenses.edit', compact('expense', 'applications'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_date' => 'required|date',
            'particulars' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:refreshment,miscellaneous',
            'bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bill')) {
            $validated['bill_path'] = $request->file('bill')->store('bills', 'public');
        }

        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }

    public function export(Request $request)
    {
        return Excel::download(new ExpensesExport($request), 'expenses.xlsx');
    }
}