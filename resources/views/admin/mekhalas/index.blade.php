@extends('layouts.app')

@section('title', 'Manage Mekhalas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mekhalas</h2>
        <a href="{{ route('admin.mekhalas.create') }}" class="btn btn-primary">Add Mekhala</a>
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
    </div>
@endsection