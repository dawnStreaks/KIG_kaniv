@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Users</h5>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Areas</h5>
                        <a href="{{ route('admin.areas.index') }}" class="btn btn-primary">Manage Areas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Mekhalas</h5>
                        <a href="{{ route('admin.mekhalas.index') }}" class="btn btn-primary">Manage Mekhalas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Units</h5>
                        <a href="{{ route('admin.units.index') }}" class="btn btn-primary">Manage Units</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection