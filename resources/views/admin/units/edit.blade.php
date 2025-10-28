@extends('layouts.app')

@section('title', 'Edit Unit')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Unit</h2>
        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Back to Units</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.units.update', $unit) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $unit->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="area_id" class="form-label">Area</label>
                    <select class="form-control @error('area_id') is-invalid @enderror" id="area_id" name="area_id" required>
                        <option value="">Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id', $unit->mekhala->area_id ?? '') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mekhala_id" class="form-label">Mekhala</label>
                    <select class="form-control @error('mekhala_id') is-invalid @enderror" id="mekhala_id" name="mekhala_id" required>
                        <option value="">Select Mekhala</option>
                        @foreach($mekhalas as $mekhala)
                            <option value="{{ $mekhala->id }}" data-area="{{ $mekhala->area_id }}" {{ old('mekhala_id', $unit->mekhala_id) == $mekhala->id ? 'selected' : '' }}>
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
                              id="description" name="description" rows="3">{{ old('description', $unit->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Unit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('area_id').addEventListener('change', function() {
            const areaId = this.value;
            const mekhalaSelect = document.getElementById('mekhala_id');
            const options = mekhalaSelect.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else if (option.dataset.area === areaId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            mekhalaSelect.value = '';
        });
        
        // Trigger on page load to filter based on current selection
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('area_id').dispatchEvent(new Event('change'));
        });
    </script>
@endsection