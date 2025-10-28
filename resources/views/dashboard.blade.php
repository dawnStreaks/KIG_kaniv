@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        <span class="badge bg-secondary">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->user_type) }})</span>
    </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Dashboard</h2>
                
                <div class="row mt-4">
                    @if(auth()->user()->isAdmin())
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Admin Panel</h5>
                                    <p class="card-text">Manage users, areas, mekhalas, and units</p>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Access</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(auth()->user()->isAreaUser() || auth()->user()->isAdmin())
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Applications</h5>
                                    <p class="card-text">Submit and manage applications</p>
                                    <a href="{{ route('applications.index') }}" class="btn btn-light">View</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Collections</h5>
                                    <p class="card-text">Unit collection entries</p>
                                    <a href="{{ route('collections.index') }}" class="btn btn-light">View</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(auth()->user()->isMekhalaUser() || auth()->user()->isAdmin())
                        <div class="col-md-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Review Applications</h5>
                                    <p class="card-text">Approve/reject applications</p>
                                    <a href="{{ route('applications.review') }}" class="btn btn-light">Review</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-danger">
                                <div class="card-body">
                                    <h5 class="card-title">Expenses</h5>
                                    <p class="card-text">Manage expenses</p>
                                    <a href="{{ route('expenses.index') }}" class="btn btn-light">View</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-secondary">
                                <div class="card-body">
                                    <h5 class="card-title">Reports</h5>
                                    <p class="card-text">Financial statements and reports</p>
                                    <a href="{{ route('reports.financial') }}" class="btn btn-light">View</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection