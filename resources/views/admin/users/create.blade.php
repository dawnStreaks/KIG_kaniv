@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Create User</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select class="form-select @error('user_type') is-invalid @enderror" 
                                id="user_type" name="user_type" required onchange="toggleRoleField()">
                            <option value="">Select User Type</option>
                            <option value="area" {{ old('user_type') == 'area' ? 'selected' : '' }}>Area</option>
                            <option value="mekhala" {{ old('user_type') == 'mekhala' ? 'selected' : '' }}>Mekhala</option>
                            <option value="center" {{ old('user_type') == 'center' ? 'selected' : '' }}>Center</option>
                        </select>
                        @error('user_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="roleField" style="display: none;">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role">
                            <option value="">Select Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="chairman" {{ old('role') == 'chairman' ? 'selected' : '' }}>Chairman</option>
                            <option value="treasurer" {{ old('role') == 'treasurer' ? 'selected' : '' }}>Treasurer</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active User
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleRoleField() {
            const userType = document.getElementById('user_type').value;
            const roleField = document.getElementById('roleField');
            const roleSelect = document.getElementById('role');
            
            if (userType === 'center') {
                roleField.style.display = 'block';
                roleSelect.innerHTML = '<option value="admin">Admin</option>';
                roleSelect.value = 'admin';
            } else if (userType === 'mekhala') {
                roleField.style.display = 'block';
                roleSelect.innerHTML = '<option value="">Select Role</option><option value="chairman">Chairman</option><option value="treasurer">Treasurer</option>';
            } else {
                roleField.style.display = 'none';
                roleSelect.value = '';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleRoleField);
    </script>
@endsection