@extends('layouts.app')

@section('title', 'Manage Areas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Areas</h2>
        <div>
            <a href="{{ route('admin.areas.export') }}" class="btn btn-success me-2">Export Excel</a>
            <a href="{{ route('admin.areas.create') }}" class="btn btn-primary">Add Area</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mekhala</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($areas as $area)
                    <tr>
                        <td>{{ $area->name }}</td>
                        <td>{{ $area->mekhala->name ?? 'N/A' }}</td>
                        <td>{{ $area->description ?? 'N/A' }}</td>
                        <td>{{ $area->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('admin.areas.edit', $area->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'areasTable';
            FilteredExport.initializeExportButton('areasTable', '{{ route("admin.areas.export") }}');
        });
    </script>
@endsection