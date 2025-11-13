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
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="particulars" class="form-label">Particulars</label>
                                <textarea class="form-control" id="particulars" name="particulars" rows="3" required>{{ old('particulars', $expense->particulars) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="refreshment" {{ old('type', $expense->type) == 'refreshment' ? 'selected' : '' }}>Refreshment</option>
                                    <option value="miscellaneous" {{ old('type', $expense->type) == 'miscellaneous' ? 'selected' : '' }}>Miscellaneous</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expense_date" class="form-label">Expense Date</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="bill" class="form-label">Upload Bill (Optional)</label>
                                @if($expense->bill_path)
                                    <div class="mb-2">
                                        <small class="text-muted">Current bill: </small>
                                        <a href="{{ asset('storage/' . $expense->bill_path) }}" target="_blank" class="btn btn-sm btn-info">View Current Bill</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="bill" name="bill" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">Accepted formats: PDF, JPG, JPEG, PNG. Max size: 2MB. Leave empty to keep current bill.</small>
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
@endsection