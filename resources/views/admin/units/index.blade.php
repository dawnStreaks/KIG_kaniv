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
                        <td><a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $units->links() }}
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'unitsTable';
            FilteredExport.initializeExportButton('unitsTable', '{{ route("admin.units.export") }}');
        });
    </script>
@endsection