@extends('layouts.app')

@section('title', 'Manage Units')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Units</h2>
        <a href="{{ route('admin.units.create') }}" class="btn btn-primary">Add Unit</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Area</th>
                        <th>Mekhala</th>
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
                        <td>{{ $unit->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection