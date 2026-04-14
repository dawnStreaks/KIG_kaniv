<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Exports\ExpensesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['application', 'enteredBy', 'paidByArea']);
        
        // Filter by mekhala for mekhala users
        if (auth()->user()->isMekhalaUser()) {
            $query->where('entered_by', auth()->id());
        }
        
        // Filter by center users for center login
        if (auth()->user()->isCenterUser()) {
            $query->whereHas('enteredBy', function($q) {
                $q->where('user_type', 'center');
            });
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
        $expenseTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        return view('expenses.index', compact('expenses', 'expenseTypes'));
    }

    public function create()
    {
        if (!auth()->user()->canAddExpenses()) {
            abort(403, 'Only treasurers can add expenses');
        }
        $expenseTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        
        // Get areas based on user type
        if (auth()->user()->isMekhalaUser()) {
            $areas = \App\Models\Area::where('mekhala_id', auth()->user()->mekhala_id)->get();
        } else {
            $areas = \App\Models\Area::all();
        }
        
        return view('expenses.create', compact('expenseTypes', 'areas'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canAddExpenses()) {
            abort(403, 'Only treasurers can add expenses');
        }

        $allowedTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        
        $validated = $request->validate([
            'expense_date' => 'required|date',
            'particulars' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:' . implode(',', $allowedTypes),
            'bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx,xls|max:2048',
            'beneficiary' => 'nullable|string|max:255',
            'paid_by_area_id' => 'nullable|exists:areas,id',
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
        $expenseTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        
        // Get areas based on user type
        if (auth()->user()->isMekhalaUser()) {
            $areas = \App\Models\Area::where('mekhala_id', auth()->user()->mekhala_id)->get();
        } else {
            $areas = \App\Models\Area::all();
        }
        
        return view('expenses.edit', compact('expense', 'applications', 'expenseTypes', 'areas'));
    }

    public function update(Request $request, Expense $expense)
    {
        $allowedTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        
        $validated = $request->validate([
            'expense_date' => 'required|date',
            'particulars' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:' . implode(',', $allowedTypes),
            'bill' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx,xls|max:2048',
            'beneficiary' => 'nullable|string|max:255',
            'paid_by_area_id' => 'nullable|exists:areas,id',
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

    public function viewBill(Expense $expense)
    {
        if (!$expense->bill_path || !Storage::disk('public')->exists($expense->bill_path)) {
            abort(404, 'Bill not found');
        }
        return Storage::disk('public')->response($expense->bill_path);
    }
}