@extends('layouts.app')

@section('title', 'Application Details - Management System')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Application Details</h2>
            <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back to Applications</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Personal Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $application->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Passport No:</strong></td>
                                <td>{{ $application->passport_no }}</td>
                            </tr>
                            <tr>
                                <td><strong>Civil ID:</strong></td>
                                <td>{{ $application->civil_id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mobile Number:</strong></td>
                                <td>{{ $application->mobile_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="badge bg-{{ $application->category == 'medical_support' ? 'success' : ($application->category == 'financial_support' ? 'info' : ($application->category == 'iqama_visa_residency' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $application->category)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Application Details</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Submitted By:</strong></td>
                                <td>{{ $application->submitter->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Submitted At:</strong></td>
                                <td>{{ $application->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @if($application->description)
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td>{{ $application->description }}</td>
                            </tr>
                            @endif
                        </table>
                        
                        @if($application->front_page_photo)
                        <div class="mt-3">
                            <h6>Front Page Photo 
                                <a href="{{ route('applications.download', $application) }}" class="btn btn-sm btn-outline-primary ms-2" title="Download Photo">
                                    <i class="fas fa-download"></i>
                                </a>
                            </h6>
                            <img src="{{ asset('storage/' . $application->front_page_photo) }}" 
                                 alt="Front Page Photo" class="img-fluid" style="max-width: 300px;">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection