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
        $query = Expense::with(['application', 'enteredBy', 'paidByArea', 'paidByMekhala']);
        
        // Filter by mekhala for mekhala users; center/admin see all expenses (same as applications)
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

        // Option lists for the column filters, drawn from the same (unpaginated) scope
        $filterScope = clone $query;
        $beneficiaryOptions = (clone $filterScope)->whereNotNull('beneficiary')->distinct()->orderBy('beneficiary')->pluck('beneficiary');
        $enteredByIds = (clone $filterScope)->pluck('entered_by')->unique();
        $enteredByOptions = \App\Models\User::whereIn('id', $enteredByIds)->orderBy('name')->pluck('name');

        $expenses = $query->latest('expense_date')->paginate(10);
        $expenseTypes = \App\Models\ExpenseType::active()->pluck('name')->toArray();
        $expenseTypeCategories = \App\Models\ExpenseType::pluck('category', 'name');
        $categories = $expenseTypeCategories->filter()->unique()->sort()->values();
        $paidByOptions = $this->paidByFilterOptions();

        return view('expenses.index', compact(
            'expenses', 'expenseTypes', 'expenseTypeCategories', 'categories',
            'beneficiaryOptions', 'enteredByOptions', 'paidByOptions'
        ));
    }

    public function create()
    {
        if (!auth()->user()->canAddExpenses()) {
            abort(403, 'Only treasurers can add expenses');
        }
        $expenseTypes = \App\Models\ExpenseType::active()->get(['name', 'category']);
        $categories = $expenseTypes->pluck('category')->filter()->unique()->sort()->values();
        $beneficiaries = \App\Models\Beneficiary::active()->orderBy('name')->pluck('name');
        $mekhalas = $this->paidByMekhalas();
        $canPayByCenter = $this->canPayByCenter();

        return view('expenses.create', compact('expenseTypes', 'categories', 'beneficiaries', 'mekhalas', 'canPayByCenter'));
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
            'custom_beneficiary' => 'nullable|string|max:255|required_if:beneficiary,__other__',
        ]);

        $validated['beneficiary'] = $this->resolveBeneficiary($request);
        unset($validated['custom_beneficiary']);

        $validated = array_merge($validated, $this->resolvePaidBy($request));

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
        $expenseTypes = \App\Models\ExpenseType::active()->get(['name', 'category']);
        $categories = $expenseTypes->pluck('category')->filter()->unique()->sort()->values();
        $beneficiaries = \App\Models\Beneficiary::active()->orderBy('name')->pluck('name');

        // Ensure the expense's current type/category still show even if the type was since deactivated
        $currentType = \App\Models\ExpenseType::where('name', $expense->type)->first();
        $selectedCategory = old('category', $currentType->category ?? '');

        $mekhalas = $this->paidByMekhalas();
        $canPayByCenter = $this->canPayByCenter();
        $selectedPaidBy = old('paid_by', $expense->paid_by_area_id
            ? 'area:' . $expense->paid_by_area_id
            : ($expense->paid_by_mekhala_id
                ? 'mekhala:' . $expense->paid_by_mekhala_id
                : ($expense->paid_by_center ? 'center:1' : '')));

        $isOtherBeneficiary = $expense->beneficiary && !$beneficiaries->contains($expense->beneficiary);
        $selectedBeneficiary = old('beneficiary', $isOtherBeneficiary ? '__other__' : $expense->beneficiary);
        $customBeneficiaryValue = old('custom_beneficiary', $isOtherBeneficiary ? $expense->beneficiary : '');

        return view('expenses.edit', compact('expense', 'applications', 'expenseTypes', 'categories', 'beneficiaries', 'selectedCategory', 'mekhalas', 'canPayByCenter', 'selectedPaidBy', 'selectedBeneficiary', 'customBeneficiaryValue'));
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
            'custom_beneficiary' => 'nullable|string|max:255|required_if:beneficiary,__other__',
        ]);

        $validated['beneficiary'] = $this->resolveBeneficiary($request);
        unset($validated['custom_beneficiary']);

        $validated = array_merge($validated, $this->resolvePaidBy($request));

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

    /**
     * Mekhalas (with their areas) a user is allowed to pick as "Paid By":
     * mekhala users only see their own mekhala, everyone else (admin/center) sees all.
     */
    private function paidByMekhalas()
    {
        $query = \App\Models\Mekhala::with('areas');

        if (auth()->user()->isMekhalaUser()) {
            $query->where('id', auth()->user()->mekhala_id);
        }

        return $query->get();
    }

    /**
     * Every label paid_by_label can produce, for the "Paid By" column filter dropdown.
     */
    private function paidByFilterOptions()
    {
        $options = collect();

        if ($this->canPayByCenter()) {
            $options->push('Center (General)');
        }

        foreach ($this->paidByMekhalas() as $mekhala) {
            $options->push($mekhala->name . ' (General)');
            foreach ($mekhala->areas as $area) {
                $options->push($area->name);
            }
        }

        return $options;
    }

    /**
     * Resolve the "beneficiary" select into a plain name: when "__other__" is
     * chosen, use the free-typed custom_beneficiary value instead.
     */
    private function resolveBeneficiary(Request $request): ?string
    {
        if ($request->input('beneficiary') === '__other__') {
            return trim($request->input('custom_beneficiary')) ?: null;
        }

        return $request->input('beneficiary') ?: null;
    }

    /**
     * Only non-mekhala users (admin/center) may tag an expense as paid by the
     * center itself, since it isn't tied to any mekhala/area.
     */
    private function canPayByCenter(): bool
    {
        return !auth()->user()->isMekhalaUser();
    }

    /**
     * Parse the combined "paid_by" select ("area:{id}", "mekhala:{id}", or "center:1")
     * into the expense's paid_by_area_id / paid_by_mekhala_id / paid_by_center columns,
     * scoped to what the current user is allowed to select.
     */
    private function resolvePaidBy(Request $request): array
    {
        $result = ['paid_by_area_id' => null, 'paid_by_mekhala_id' => null, 'paid_by_center' => false];

        if (!$request->filled('paid_by')) {
            return $result;
        }

        [$kind, $id] = array_pad(explode(':', $request->input('paid_by'), 2), 2, null);
        $allowedMekhalaIds = $this->paidByMekhalas()->pluck('id');

        if ($kind === 'area') {
            $area = \App\Models\Area::find($id);
            if (!$area || !$allowedMekhalaIds->contains($area->mekhala_id)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['paid_by' => 'Invalid paid by selection.']);
            }
            $result['paid_by_area_id'] = $area->id;
        } elseif ($kind === 'mekhala') {
            if (!$allowedMekhalaIds->contains((int) $id)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['paid_by' => 'Invalid paid by selection.']);
            }
            $result['paid_by_mekhala_id'] = (int) $id;
        } elseif ($kind === 'center') {
            if (!$this->canPayByCenter()) {
                throw \Illuminate\Validation\ValidationException::withMessages(['paid_by' => 'Invalid paid by selection.']);
            }
            $result['paid_by_center'] = true;
        } else {
            throw \Illuminate\Validation\ValidationException::withMessages(['paid_by' => 'Invalid paid by selection.']);
        }

        return $result;
    }
}