@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Add New Expense</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.001" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="particulars" class="form-label">Particulars</label>
                                <textarea class="form-control" id="particulars" name="particulars" rows="3" required>{{ old('particulars') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
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
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ old('expense_date') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="beneficiary" class="form-label">Beneficiary (Optional)</label>
                                <select class="form-control" id="beneficiary" name="beneficiary">
                                    <option value="">Select Beneficiary</option>
                                    @foreach($beneficiaries as $beneficiary)
                                        <option value="{{ $beneficiary }}" {{ old('beneficiary') == $beneficiary ? 'selected' : '' }}>{{ $beneficiary }}</option>
                                    @endforeach
                                    <option value="__other__" {{ old('beneficiary') == '__other__' ? 'selected' : '' }}>Other</option>
                                </select>
                                <input type="text" class="form-control mt-2 d-none" id="custom_beneficiary" name="custom_beneficiary" placeholder="Enter custom beneficiary name" value="{{ old('custom_beneficiary') }}">
                            </div>
                            <div class="mb-3">
                                <label for="paid_by" class="form-label">Paid By (Optional)</label>
                                <select class="form-control" id="paid_by" name="paid_by">
                                    <option value="">Select Mekhala / Area</option>
                                    @if($canPayByCenter)
                                        <optgroup label="Center">
                                            <option value="center:1" {{ old('paid_by') == 'center:1' ? 'selected' : '' }}>Center General</option>
                                        </optgroup>
                                    @endif
                                    @foreach($mekhalas as $mekhala)
                                        <optgroup label="{{ $mekhala->name }}">
                                            <option value="mekhala:{{ $mekhala->id }}" {{ old('paid_by') == 'mekhala:' . $mekhala->id ? 'selected' : '' }}>{{ $mekhala->name }} (General)</option>
                                            @foreach($mekhala->areas as $area)
                                                <option value="area:{{ $area->id }}" {{ old('paid_by') == 'area:' . $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Pick the mekhala's general option if the expense isn't tied to a specific area.</small>
                            </div>
                            <div class="mb-3">
                                <label for="bill" class="form-label">Upload Bill (Optional)</label>
                                <input type="file" class="form-control" id="bill" name="bill" accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls">
                                <small class="form-text text-muted">Accepted formats: PDF, JPG, JPEG, PNG, XLSX, XLS. Max size: 2MB</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Expense</button>
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
            const oldType = @json(old('type'));

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
            }

            categorySelect.addEventListener('change', function() {
                populateTypes(this.value, null);
            });

            populateTypes(categorySelect.value, oldType);

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