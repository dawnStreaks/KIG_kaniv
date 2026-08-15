@extends('layouts.app')

@section('title', 'Application History')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Application History</h2>
            <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back to Applications</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Current Application</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $application->name }}</p>
                        <p><strong>Civil ID:</strong> {{ $application->civil_id }}</p>
                        <p><strong>Mobile:</strong> {{ $application->mobile_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Category:</strong> {{ ucfirst($application->category) }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($application->status) }}</span></p>
                        <p><strong>Submitted:</strong> {{ $application->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($duplicates->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Related Applications ({{ $duplicates->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Civil ID</th>
                                    <th>Passport No</th>
                                    <th>Mobile</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($duplicates as $duplicate)
                                    <tr>
                                        <td>{{ $duplicate->id }}</td>
                                        <td>{{ $duplicate->name }}</td>
                                        <td>{{ $duplicate->civil_id }}</td>
                                        <td>{{ $duplicate->passport_no }}</td>
                                        <td>{{ $duplicate->mobile_number }}</td>
                                        <td>{{ ucfirst($duplicate->category) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $duplicate->status == 'approved' ? 'success' : ($duplicate->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($duplicate->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $duplicate->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('applications.show', $duplicate) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($historicalDuplicates->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-warning-subtle">
                    <h5 class="mb-0">Historical Records ({{ $historicalDuplicates->count() }}) <small class="text-muted fw-normal">— matched from imported historical data</small></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Civil ID</th>
                                    <th>Passport No</th>
                                    <th>Mobile</th>
                                    <th>Category</th>
                                    <th>Application Type</th>
                                    <th>Area</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Applied Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historicalDuplicates as $h)
                                    <tr>
                                        <td>{{ $h->name }}</td>
                                        <td>{{ $h->civil_id ?? '-' }}</td>
                                        <td>{{ $h->passport_no ?? '-' }}</td>
                                        <td>{{ $h->mobile_number ?? '-' }}</td>
                                        <td>{{ $h->category ?? '-' }}</td>
                                        <td>{{ $h->application_type ?? '-' }}</td>
                                        <td>{{ $h->area_name ?? '-' }}</td>
                                        <td>{{ $h->unit_name ?? '-' }}</td>
                                        <td>{{ $h->status ?? '-' }}</td>
                                        <td>{{ $h->approved_amount ? number_format($h->approved_amount, 3) : '-' }}</td>
                                        <td>{{ $h->applied_date ? $h->applied_date->format('Y-m-d') : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($duplicates->count() === 0 && $historicalDuplicates->count() === 0)
            <div class="alert alert-info">
                No related applications found with the same Civil ID, Passport No, or Mobile Number.
            </div>
        @endif
    </div>
@endsection