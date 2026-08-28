@extends('layouts.app')

@section('title', 'Applications - Management System')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Applications</h2>
            <div>
                <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">Clear Filters</button>
                <a href="{{ route('applications.export') }}" class="btn btn-success me-2">Export Excel</a>
                @if(auth()->user()->canCreateApplications())
                    <a href="{{ route('applications.create') }}" class="btn btn-primary">New Application</a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="GET" id="filterForm">
                <div class="table-responsive">
                    <table class="table table-striped" id="applicationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Passport No</th>
                                <th>Civil ID</th>
                                <th>Mobile</th>
                                <th>Category</th>
                                <th>Application Term</th>
                                <th>Area</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Approved Amount</th>
                                <th>Submitted By</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" name="id" placeholder="Filter ID" value="{{ request('id') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="name" placeholder="Filter Name" value="{{ request('name') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="passport" placeholder="Filter Passport" value="{{ request('passport') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="civil_id" placeholder="Filter Civil ID" value="{{ request('civil_id') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="mobile" placeholder="Filter Mobile" value="{{ request('mobile') }}"></th>
                                <th><select class="form-control form-control-sm" name="category"><option value="">All Categories</option><option value="medical_support" {{ request('category') == 'medical_support' ? 'selected' : '' }}>Medical Support</option><option value="financial_support" {{ request('category') == 'financial_support' ? 'selected' : '' }}>Financial Support</option><option value="iqama_visa_residency" {{ request('category') == 'iqama_visa_residency' ? 'selected' : '' }}>Iqama/Visa/Residency</option><option value="ticket" {{ request('category') == 'ticket' ? 'selected' : '' }}>Ticket</option></select></th>
                                <th><select class="form-control form-control-sm" name="application_type"><option value="">All Terms</option>@foreach($applicationTypes as $type)<option value="{{ $type->name }}" {{ request('application_type') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>@endforeach</select></th>
                                <th><select class="form-control form-control-sm" name="area_id"><option value="">All Areas</option>@foreach($areas as $area)<option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>@endforeach</select></th>
                                <th><select class="form-control form-control-sm" name="unit_id"><option value="">All Units</option>@foreach($units as $unit)<option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>@endforeach</select></th>
                                <th><select class="form-control form-control-sm" name="status"><option value="">All Status</option><option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option><option value="payable" {{ request('status') == 'payable' ? 'selected' : '' }}>Payable</option><option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option><option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option></select></th>
                                <th><input type="text" class="form-control form-control-sm" name="amount" placeholder="Filter Amount" value="{{ request('amount') }}"></th>
                                <th><select class="form-control form-control-sm" name="submitter"><option value="">All Submitters</option>@foreach($submitters as $submitter)<option value="{{ $submitter->name }}" {{ request('submitter') == $submitter->name ? 'selected' : '' }}>{{ $submitter->name }}</option>@endforeach</select></th>
                                <th></th>
                            </tr>
                        </thead>
                </form>
                        <tbody>
                            @forelse($applications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>{{ $application->name }}</td>
                                    <td>{{ $application->passport_no }}</td>
                                    <td>{{ $application->civil_id }}</td>
                                    <td>{{ $application->mobile_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $application->category == 'medical_support' ? 'success' : ($application->category == 'financial_support' ? 'info' : ($application->category == 'iqama_visa_residency' ? 'warning' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $application->category)) }}
                                        </span>
                                    </td>
                                    <td>{{ $application->applicationType->name ?? 'N/A' }}</td>
                                    <td>{{ $application->area->name ?? 'N/A' }}</td>
                                    <td>{{ $application->unit->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $application->status == 'paid' ? 'success' : ($application->status == 'payable' ? 'info' : ($application->status == 'rejected' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($application->approved_amount)
                                            KWD {{ number_format($application->approved_amount, 3) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $application->submitter->name }}</td>
                                    <td>
                                        <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        @if($application->status == 'pending' && ($application->submitted_by == auth()->id() || auth()->user()->isMekhalaUser() || auth()->user()->isCenterUser()))
                                            <a href="{{ route('applications.edit', $application) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <form method="POST" action="{{ route('applications.destroy', $application) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this application?')">Delete</button>
                                            </form>
                                        @endif
                                        @if($application->status == 'pending' && auth()->user()->canApproveApplications())
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $application->id }}">Approve</button>
                                            <form method="POST" action="{{ route('applications.reject', $application->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        @elseif($application->status == 'payable' && auth()->user()->isTreasurer())
                                            <form method="POST" action="{{ route('applications.pay', $application) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this application as paid?')">Pay</button>
                                            </form>
                                        @endif
                                        @php
                                            $hasDuplicates = \App\Models\Application::where(function($query) use ($application) {
                                                $query->where('civil_id', $application->civil_id)
                                                      ->orWhere('mobile_number', $application->mobile_number);
                                            })->where('id', '!=', $application->id)->exists();
                                        @endphp
                                        @if($hasDuplicates)
                                            <a href="{{ route('applications.history', $application) }}" class="btn btn-sm btn-outline-info">History</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">No applications found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $applications->links('pagination.custom') }}
            </div>
        </div>
    </div>

    <!-- Approval Modals -->
    @foreach($applications as $application)
        @if($application->status == 'pending')
        <div class="modal fade" id="approveModal{{ $application->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('applications.approve', $application->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Application - {{ $application->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="approved_amount{{ $application->id }}" class="form-label">Approved Amount (KWD)</label>
                                <input type="number" step="0.01" class="form-control" id="approved_amount{{ $application->id }}" name="approved_amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="approved_date{{ $application->id }}" class="form-label">Approved Date</label>
                                <input type="date" class="form-control" id="approved_date{{ $application->id }}" name="approved_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    form.submit();
                });
                
                input.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        form.submit();
                    }
                });
            });
        });
        
        function clearFilters() {
            window.location.href = '{{ route('applications.index') }}';
        }
    </script>
@endsection