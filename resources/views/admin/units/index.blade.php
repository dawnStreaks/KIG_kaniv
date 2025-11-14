@extends('layouts.app')

@section('title', 'Manage Units')

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
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Filter by name" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="area" class="form-control" placeholder="Filter by area" value="{{ request('area') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="mekhala" class="form-control" placeholder="Filter by mekhala" value="{{ request('mekhala') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Area</th>
                        <th>Mekhala</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->area->name ?? 'N/A' }}</td>
                        <td>{{ $unit->area->mekhala->name ?? 'N/A' }}</td>
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
            
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $units->links() }}
        </div>
    </div>
    

@endsection
