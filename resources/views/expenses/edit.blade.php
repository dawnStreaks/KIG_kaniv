@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Expense</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('expenses.update', $expense) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.001" class="form-control" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="particulars" class="form-label">Particulars</label>
                                <textarea class="form-control" id="particulars" name="particulars" rows="3" required>{{ old('particulars', $expense->particulars) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ $selectedCategory == $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expense_date" class="form-label">Expense Date</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="beneficiary" class="form-label">Beneficiary (Optional)</label>
                                <select class="form-control" id="beneficiary" name="beneficiary">
                                    <option value="">Select Beneficiary</option>
                                    @foreach($beneficiaries as $beneficiary)
                                        <option value="{{ $beneficiary }}" {{ $selectedBeneficiary == $beneficiary ? 'selected' : '' }}>{{ $beneficiary }}</option>
                                    @endforeach
                                    <option value="__other__" {{ $selectedBeneficiary == '__other__' ? 'selected' : '' }}>Other</option>
                                </select>
                                <input type="text" class="form-control mt-2 {{ $selectedBeneficiary == '__other__' ? '' : 'd-none' }}" id="custom_beneficiary" name="custom_beneficiary" placeholder="Enter custom beneficiary name" value="{{ $customBeneficiaryValue }}">
                            </div>
                            <div class="mb-3">
                                <label for="paid_by" class="form-label">Paid By (Optional)</label>
                                @php
                                    $knownPaidByValues = $mekhalas->flatMap(function ($mekhala) {
                                        return $mekhala->areas->pluck('id')->map(fn($id) => 'area:' . $id)
                                            ->push('mekhala:' . $mekhala->id);
                                    });
                                    if ($canPayByCenter) {
                                        $knownPaidByValues->push('center:1');
                                    }
                                @endphp
                                <select class="form-control" id="paid_by" name="paid_by">
                                    <option value="">Select Mekhala / Area</option>
                                    @if($canPayByCenter)
                                        <optgroup label="Center">
                                            <option value="center:1" {{ $selectedPaidBy == 'center:1' ? 'selected' : '' }}>Center General</option>
                                        </optgroup>
                                    @endif
                                    @foreach($mekhalas as $mekhala)
                                        <optgroup label="{{ $mekhala->name }}">
                                            <option value="mekhala:{{ $mekhala->id }}" {{ $selectedPaidBy == 'mekhala:' . $mekhala->id ? 'selected' : '' }}>{{ $mekhala->name }} (General)</option>
                                            @foreach($mekhala->areas as $area)
                                                <option value="area:{{ $area->id }}" {{ $selectedPaidBy == 'area:' . $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                    @if($selectedPaidBy && !$knownPaidByValues->contains($selectedPaidBy))
                                        <option value="{{ $selectedPaidBy }}" selected>{{ $expense->paid_by_label ?? $selectedPaidBy }}</option>
                                    @endif
                                </select>
                                <small class="form-text text-muted">Pick the mekhala's general option if the expense isn't tied to a specific area.</small>
                            </div>
                            <div class="mb-3">
                                <label for="bill" class="form-label">Upload Bill (Optional)</label>
                                @if($expense->bill_path)
                                    <div class="mb-2">
                                        <small class="text-muted">Current bill: </small>
                                        <a href="{{ asset('storage/' . $expense->bill_path) }}" target="_blank" class="btn btn-sm btn-info">View Current Bill</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="bill" name="bill" accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls">
                                <small class="form-text text-muted">Accepted formats: PDF, JPG, JPEG, PNG, XLSX, XLS. Max size: 2MB. Leave empty to keep current bill.</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Expense</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expenseTypes = @json($expenseTypes);
            const categorySelect = document.getElementById('category');
            const typeSelect = document.getElementById('type');
            const currentType = @json(old('type', $expense->type));

            function populateTypes(category, selected) {
                typeSelect.innerHTML = '<option value="">Select Type</option>';
                expenseTypes
                    .filter(t => !category || t.category === category)
                    .forEach(t => {
                        const option = document.createElement('option');
                        option.value = t.name;
                        option.textContent = t.name;
                        if (t.name === selected) {
                            option.selected = true;
                        }
                        typeSelect.appendChild(option);
                    });

                // Keep a deactivated/legacy type visible so editing doesn't silently change it
                if (selected && ![...typeSelect.options].some(o => o.value === selected)) {
                    const option = document.createElement('option');
                    option.value = selected;
                    option.textContent = selected;
                    option.selected = true;
                    typeSelect.appendChild(option);
                }
            }

            categorySelect.addEventListener('change', function() {
                populateTypes(this.value, null);
            });

            populateTypes(categorySelect.value, currentType);

            const beneficiarySelect = document.getElementById('beneficiary');
            const customBeneficiaryInput = document.getElementById('custom_beneficiary');

            function toggleCustomBeneficiary() {
                const isOther = beneficiarySelect.value === '__other__';
                customBeneficiaryInput.classList.toggle('d-none', !isOther);
                customBeneficiaryInput.required = isOther;
            }

            beneficiarySelect.addEventListener('change', toggleCustomBeneficiary);
            toggleCustomBeneficiary();
        });
    </script>
@endsection