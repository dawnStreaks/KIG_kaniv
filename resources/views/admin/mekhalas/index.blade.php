@extends('layouts.app')

@section('title', 'Manage Mekhalas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mekhalas</h2>
        <div>
            <a href="{{ route('admin.mekhalas.export') }}" class="btn btn-success me-2">Export Excel</a>
            <a href="{{ route('admin.mekhalas.create') }}" class="btn btn-primary">Add Mekhala</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mekhalas as $mekhala)
                    <tr>
                        <td>{{ $mekhala->name }}</td>
                        <td>{{ $mekhala->description ?? 'N/A' }}</td>
                        <td>{{ $mekhala->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('admin.mekhalas.edit', $mekhala->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $mekhalas->links('pagination.custom') }}
    </div>
    
    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'mekhalasTable';
            FilteredExport.initializeExportButton('mekhalasTable', '{{ route("admin.mekhalas.export") }}');
        });
    </script>
@endsection