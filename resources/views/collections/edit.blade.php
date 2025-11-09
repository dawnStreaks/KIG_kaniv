@extends('layouts.app')

@section('title', 'Edit Collection')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Collection</h2>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Back to Collections</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('collections.update', $collection) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id', $collection->unit_id) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (KWD)</label>
                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                           id="amount" name="amount" value="{{ old('amount', $collection->amount) }}" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="collection_date" class="form-label">Collection Date</label>
                    <input type="date" class="form-control @error('collection_date') is-invalid @enderror" 
                           id="collection_date" name="collection_date" value="{{ old('collection_date', $collection->collection_date) }}" required>
                    @error('collection_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Select Type</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type', $collection->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="term" class="form-label">Term</label>
                    <select class="form-control @error('term') is-invalid @enderror" id="term" name="term" required>
                        <option value="">Select Term</option>
                        @foreach($terms as $term)
                            <option value="{{ $term }}" {{ old('term', $collection->term) == $term ? 'selected' : '' }}>{{ $term }}</option>
                        @endforeach
                    </select>
                    @error('term')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes', $collection->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Collection</button>
            </form>
        </div>
    </div>
@endsection