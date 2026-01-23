@extends('layouts.app')

@section('title', 'Application Terms')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Application Terms</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.application-types.store') }}" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="Enter application term name" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Add Type</button>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applicationTypes as $type)
                        <tr>
                            <td>
                                <span class="type-name">{{ $type->name }}</span>
                                <input type="text" class="form-control edit-input d-none" value="{{ $type->name }}" data-id="{{ $type->id }}">
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" data-id="{{ $type->id }}" {{ $type->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $type->is_active ? 'Active' : 'Inactive' }}</label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $type->id }}">Edit</button>
                                <button class="btn btn-sm btn-success save-btn d-none" data-id="{{ $type->id }}">Save</button>
                                <button class="btn btn-sm btn-secondary cancel-btn d-none">Cancel</button>
                                <form method="POST" action="{{ route('admin.application-types.destroy', $type->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this type?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    row.querySelector('.type-name').classList.add('d-none');
                    row.querySelector('.edit-input').classList.remove('d-none');
                    row.querySelector('.edit-btn').classList.add('d-none');
                    row.querySelector('.save-btn').classList.remove('d-none');
                    row.querySelector('.cancel-btn').classList.remove('d-none');
                });
            });

            document.querySelectorAll('.cancel-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    row.querySelector('.type-name').classList.remove('d-none');
                    row.querySelector('.edit-input').classList.add('d-none');
                    row.querySelector('.edit-btn').classList.remove('d-none');
                    row.querySelector('.save-btn').classList.add('d-none');
                    row.querySelector('.cancel-btn').classList.add('d-none');
                });
            });

            document.querySelectorAll('.save-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const row = this.closest('tr');
                    const newName = row.querySelector('.edit-input').value;
                    
                    fetch(`{{ url('/admin/application-types') }}/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ name: newName })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.querySelector('.type-name').textContent = newName;
                            row.querySelector('.cancel-btn').click();
                        }
                    });
                });
            });
            
            document.querySelectorAll('.status-toggle').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const id = this.dataset.id;
                    const isActive = this.checked;
                    const label = this.nextElementSibling;
                    
                    fetch(`{{ url('/admin/application-types') }}/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ is_active: isActive })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            label.textContent = isActive ? 'Active' : 'Inactive';
                        } else {
                            this.checked = !isActive;
                        }
                    });
                });
            });
        });
    </script>
@endsection