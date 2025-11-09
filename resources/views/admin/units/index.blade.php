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
        
        <div class="d-flex justify-content-center mt-3">
            {{ $units->links() }}
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'unitsTable';
            
            // Prevent auto-initialization of table utils for this page
            table.setAttribute('data-no-auto-init', 'true');
        });
    </script>
@endsection
