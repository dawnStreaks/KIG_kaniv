@extends('layouts.app')

@section('title', 'Edit Mekhala')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Mekhala</h2>
        <a href="{{ route('admin.mekhalas.index') }}" class="btn btn-secondary">Back to Mekhalas</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.mekhalas.update', $mekhala) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $mekhala->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $mekhala->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Mekhala</button>
            </form>
        </div>
    </div>
@endsection