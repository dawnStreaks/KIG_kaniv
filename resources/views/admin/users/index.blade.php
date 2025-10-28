@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Users</h2>
            <div>
                <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">Clear Filters</button>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Name" data-column="0"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Email" data-column="1"></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Types</option><option value="admin">Admin</option><option value="manager">Manager</option><option value="employee">Employee</option></select></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="3"><option value="">All Status</option><option value="active">Active</option><option value="inactive">Inactive</option></select></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->user_type) }}</td>
                            <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            <td><a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = document.querySelectorAll('.filter-input');
            const tableRows = document.querySelectorAll('tbody tr');
            
            filterInputs.forEach(input => {
                input.addEventListener('input', function() {
                    filterTable();
                });
            });
            
            function filterTable() {
                tableRows.forEach(row => {
                    let showRow = true;
                    
                    filterInputs.forEach(input => {
                        const column = input.dataset.column;
                        const filterValue = input.value.toLowerCase();
                        const cellValue = row.cells[column].textContent.toLowerCase();
                        
                        if (filterValue && !cellValue.includes(filterValue)) {
                            showRow = false;
                        }
                    });
                    
                    row.style.display = showRow ? '' : 'none';
                });
            }
        });
        
        function clearFilters() {
            const filterInputs = document.querySelectorAll('.filter-input');
            filterInputs.forEach(input => {
                input.value = '';
                input.dispatchEvent(new Event('input'));
            });
        }
    </script>
@endsection