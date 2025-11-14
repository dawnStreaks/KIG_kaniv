@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Users</h2>
            <div>
                <a href="{{ route('admin.users.export') }}" class="btn btn-success me-2">Export Excel</a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
            </div>
        </div>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Filter Name" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="email" class="form-control" placeholder="Filter Email" value="{{ request('email') }}">
                </div>
                <div class="col-md-2">
                    <select name="user_type" class="form-control">
                        <option value="">All Types</option>
                        <option value="area" {{ request('user_type') === 'area' ? 'selected' : '' }}>Area</option>
                        <option value="mekhala" {{ request('user_type') === 'mekhala' ? 'selected' : '' }}>Mekhala</option>
                        <option value="center" {{ request('user_type') === 'center' ? 'selected' : '' }}>Center</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-control">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="chairman" {{ request('role') === 'chairman' ? 'selected' : '' }}>Chairman</option>
                        <option value="treasurer" {{ request('role') === 'treasurer' ? 'selected' : '' }}>Treasurer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->user_type) }}</td>
                            <td>{{ $user->role ? ucfirst($user->role) : 'N/A' }}</td>
                            <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            <td><a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $users->links('pagination.custom') }}
        </div>
    </div>


@endsection