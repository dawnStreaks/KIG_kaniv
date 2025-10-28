@extends('layouts.app')

@section('title', 'Edit Area')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Area</h2>
        <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">Back to Areas</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.areas.update', $area) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $area->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mekhala_id" class="form-label">Mekhala</label>
                    <select class="form-control @error('mekhala_id') is-invalid @enderror" id="mekhala_id" name="mekhala_id" required>
                        <option value="">Select Mekhala</option>
                        @foreach($mekhalas as $mekhala)
                            <option value="{{ $mekhala->id }}" {{ old('mekhala_id', $area->mekhala_id) == $mekhala->id ? 'selected' : '' }}>
                                {{ $mekhala->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('mekhala_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $area->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Area</button>
            </form>
        </div>
    </div>
@endsection