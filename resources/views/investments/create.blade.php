@extends('layouts.app')

@section('title', 'Add Investment')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add Investment</h2>
        <a href="{{ route('investments.index') }}" class="btn btn-secondary">Back to Investments</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('investments.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="investment_date" class="form-label">Investment Date</label>
                            <input type="date" class="form-control @error('investment_date') is-invalid @enderror" 
                                   id="investment_date" name="investment_date" value="{{ old('investment_date', date('Y-m-d')) }}" required>
                            @error('investment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Investment Amount (KWD)</label>
                            <input type="number" step="0.001" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create Investment</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Available Funds</h5>
                </div>
                <div class="card-body">
                    <p class="h4 text-success">KWD {{ number_format($availableAmount, 3) }}</p>
                    <small class="text-muted">Available from pending collections</small>
                </div>
            </div>
        </div>
    </div>
@endsection