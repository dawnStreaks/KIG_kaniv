@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit User</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_type" class="form-label">User Type</label>
                    <select class="form-control @error('user_type') is-invalid @enderror" id="user_type" name="user_type" required>
                        <option value="area" {{ old('user_type', $user->user_type) == 'area' ? 'selected' : '' }}>Area</option>
                        <option value="mekhala" {{ old('user_type', $user->user_type) == 'mekhala' ? 'selected' : '' }}>Mekhala</option>
                        <option value="center" {{ old('user_type', $user->user_type) == 'center' ? 'selected' : '' }}>Center</option>
                    </select>
                    @error('user_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mekhala_id" class="form-label">Mekhala</label>
                    <select class="form-control @error('mekhala_id') is-invalid @enderror" id="mekhala_id" name="mekhala_id">
                        <option value="">Select Mekhala</option>
                        @foreach($mekhalas as $mekhala)
                            <option value="{{ $mekhala->id }}" {{ old('mekhala_id', $user->mekhala_id) == $mekhala->id ? 'selected' : '' }}>
                                {{ $mekhala->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('mekhala_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="area_id" class="form-label">Area</label>
                    <select class="form-control @error('area_id') is-invalid @enderror" id="area_id" name="area_id">
                        <option value="">Select Area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id', $user->area_id) == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>
@endsection