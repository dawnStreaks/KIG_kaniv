@extends('layouts.app')

@section('title', 'Manage Units')

@push('styles')
<style>
.pagination .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Units</h2>
        <div>
            <a href="{{ route('admin.units.export') }}" class="btn btn-success me-2">Export Excel</a>
            <a href="{{ route('admin.units.create') }}" class="btn btn-primary">Add Unit</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" id="filterForm">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Area</th>
                        <th>Mekhala</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th><input type="text" name="name" class="form-control form-control-sm" placeholder="Filter" value="{{ request('name') }}"></th>
                        <th>
                            <select name="area" class="form-control form-control-sm">
                                <option value="">All Areas</option>
                                @foreach($allAreas as $area)
                                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select name="mekhala" class="form-control form-control-sm">
                                <option value="">All Mekhalas</option>
                                @foreach($allMekhalas as $mekhala)
                                    <option value="{{ $mekhala->id }}" {{ request('mekhala') == $mekhala->id ? 'selected' : '' }}>{{ $mekhala->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select name="type" class="form-control form-control-sm">
                                <option value="">All Types</option>
                                @foreach($allTypes as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->area->name ?? 'N/A' }}</td>
                        <td>{{ $unit->area->mekhala->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-info">{{ $unit->type ?? 'IWA' }}</span></td>
                        <td>
                            <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $unit->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $unit->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form method="POST" action="{{ route('admin.units.destroy', $unit) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this unit?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $units->links('pagination.custom') }}
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
    </script>

@endsection
