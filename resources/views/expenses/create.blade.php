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

                        <form method="POST" action="{{ route('expenses.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="particulars" class="form-label">Particulars</label>
                                <textarea class="form-control" id="particulars" name="particulars" rows="3" required>{{ old('particulars') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="refreshment" {{ old('type') == 'refreshment' ? 'selected' : '' }}>Refreshment</option>
                                    <option value="miscellaneous" {{ old('type') == 'miscellaneous' ? 'selected' : '' }}>Miscellaneous</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expense_date" class="form-label">Expense Date</label>
                                <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ old('expense_date') }}" required>
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
@endsection