@extends('layouts.app')

@section('title', 'Manage Types')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Collection Types</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $type)
                            <tr>
                                <td>
                                    <span class="type-name" id="type-{{ $type->id }}">{{ $type->name }}</span>
                                    <input type="text" class="form-control form-control-sm d-none" id="edit-type-{{ $type->id }}" value="{{ $type->name }}">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status-{{ $type->id }}" {{ $type->is_active ? 'checked' : '' }} onchange="toggleTypeStatus({{ $type->id }})">
                                        <label class="form-check-label" for="status-{{ $type->id }}">{{ $type->is_active ? 'Active' : 'Inactive' }}</label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editType({{ $type->id }})">Edit</button>
                                    <button type="button" class="btn btn-sm btn-success d-none" onclick="saveType({{ $type->id }})">Save</button>
                                    <form method="POST" action="{{ route('admin.types.destroy', $type->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Type</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.types.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Type Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editType(id) {
            document.getElementById('type-' + id).classList.add('d-none');
            document.getElementById('edit-type-' + id).classList.remove('d-none');
            document.querySelector(`[onclick="editType(${id})"]`).classList.add('d-none');
            document.querySelector(`[onclick="saveType(${id})"]`).classList.remove('d-none');
        }
        
        function saveType(id) {
            const newValue = document.getElementById('edit-type-' + id).value;
            
            fetch(`/admin/types/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: newValue })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('type-' + id).textContent = newValue;
                    document.getElementById('type-' + id).classList.remove('d-none');
                    document.getElementById('edit-type-' + id).classList.add('d-none');
                    document.querySelector(`[onclick="editType(${id})"]`).classList.remove('d-none');
                    document.querySelector(`[onclick="saveType(${id})"]`).classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update type');
            });
        }
        
        function toggleTypeStatus(id) {
            const checkbox = document.getElementById('status-' + id);
            const label = checkbox.nextElementSibling;
            
            fetch(`/admin/types/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ is_active: checkbox.checked })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    label.textContent = checkbox.checked ? 'Active' : 'Inactive';
                } else {
                    checkbox.checked = !checkbox.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked;
                alert('Failed to update status');
            });
        }
    </script>
@endsection