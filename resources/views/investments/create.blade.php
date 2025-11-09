@extends('layouts.app')

@section('title', 'Add Investment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Add New Investment</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    Available Amount for Investment: ₹{{ number_format($availableAmount, 2) }}
                </div>

                <form method="POST" action="{{ route('investments.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="investment_date" class="form-label">Investment Date</label>
                        <input type="date" class="form-control" id="investment_date" name="investment_date" value="{{ old('investment_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" max="{{ $availableAmount }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('investments.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Investment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection