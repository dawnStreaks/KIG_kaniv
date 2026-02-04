@extends('layouts.app')

@section('title', 'Manage Terms')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Collection Terms</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="termsTable">
                        <thead>
                            <tr>
                                <th>Term Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" id="filterName" placeholder="Filter by name"></th>
                                <th>
                                    <select class="form-select form-select-sm" id="filterStatus">
                                        <option value="">All</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($terms as $term)
                            <tr class="term-row">
                                <td>
                                    <span class="term-name" id="term-{{ $term->id }}">{{ $term->name }}</span>
                                    <input type="text" class="form-control form-control-sm d-none" id="edit-term-{{ $term->id }}" value="{{ $term->name }}">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status-{{ $term->id }}" {{ $term->is_active ? 'checked' : '' }} onchange="toggleTermStatus({{ $term->id }})">
                                        <label class="form-check-label" for="status-{{ $term->id }}">{{ $term->is_active ? 'Active' : 'Inactive' }}</label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editTerm({{ $term->id }})">Edit</button>
                                    <button type="button" class="btn btn-sm btn-success d-none" onclick="saveTerm({{ $term->id }})">Save</button>
                                    <form method="POST" action="{{ route('admin.terms.destroy', $term->id) }}" class="d-inline">
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
                    <h5>Add New Term</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.terms.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Term Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Term</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterName = document.getElementById('filterName');
            const filterStatus = document.getElementById('filterStatus');
            
            function filterTable() {
                const nameValue = filterName.value.toLowerCase();
                const statusValue = filterStatus.value;
                const rows = document.querySelectorAll('.term-row');
                
                rows.forEach(row => {
                    const name = row.querySelector('.term-name').textContent.toLowerCase();
                    const statusLabel = row.querySelector('.form-check-label').textContent.toLowerCase();
                    
                    const nameMatch = name.includes(nameValue);
                    const statusMatch = !statusValue || 
                        (statusValue === 'active' && statusLabel === 'active') ||
                        (statusValue === 'inactive' && statusLabel === 'inactive');
                    
                    row.style.display = nameMatch && statusMatch ? '' : 'none';
                });
            }
            
            filterName.addEventListener('keyup', filterTable);
            filterStatus.addEventListener('change', filterTable);
        });
        
        function editTerm(index) {
            document.getElementById('term-' + index).classList.add('d-none');
            document.getElementById('edit-term-' + index).classList.remove('d-none');
            document.querySelector(`[onclick="editTerm(${index})"]`).classList.add('d-none');
            document.querySelector(`[onclick="saveTerm(${index})"]`).classList.remove('d-none');
        }
        
        function saveTerm(index) {
            const newValue = document.getElementById('edit-term-' + index).value;
            
            fetch(`{{ url('/admin/terms') }}/${index}`, {
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
                    document.getElementById('term-' + index).textContent = newValue;
                    document.getElementById('term-' + index).classList.remove('d-none');
                    document.getElementById('edit-term-' + index).classList.add('d-none');
                    document.querySelector(`[onclick="editTerm(${index})"]`).classList.remove('d-none');
                    document.querySelector(`[onclick="saveTerm(${index})"]`).classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update term');
            });
        }
        
        function toggleTermStatus(id) {
            const checkbox = document.getElementById('status-' + id);
            const label = checkbox.nextElementSibling;
            
            fetch(`{{ url('/admin/terms') }}/${id}/toggle-status`, {
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