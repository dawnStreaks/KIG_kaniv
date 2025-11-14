@extends('layouts.app')

@section('title', 'Applications - Management System')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Applications</h2>
            <div>
                <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">Clear Filters</button>
                <a href="{{ route('applications.export') }}" class="btn btn-success me-2">Export Excel</a>
                <a href="{{ route('applications.create') }}" class="btn btn-primary">New Application</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
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
                                <th>Application Type</th>
                                <th>Area</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Approved Amount</th>
                                <th>Submitted By</th>
                                <th>Actions</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter ID"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Name"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Passport"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Civil ID"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Mobile"></th>
                                <th><select class="form-control form-control-sm"><option value="">All Categories</option><option value="medical_support">Medical Support</option><option value="financial_support">Financial Support</option><option value="iqama_visa_residency">Iqama/Visa/Residency</option><option value="ticket">Ticket</option></select></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Type"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Area"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Unit"></th>
                                <th><select class="form-control form-control-sm"><option value="">All Status</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Amount"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Filter Submitter"></th>
                                <th></th>
                            </tr>
                        </thead>
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
                                    <td>{{ $application->submitter->area->name ?? 'N/A' }}</td>
                                    <td>{{ $application->submitter->unit->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
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
                                        @if($application->submitted_by == auth()->id() && $application->status == 'pending')
                                            <a href="{{ route('applications.edit', $application) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
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

    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('applicationsTable');
            const filterInputs = table.querySelectorAll('thead tr:nth-child(2) input, thead tr:nth-child(2) select');
            const rows = table.querySelectorAll('tbody tr');
            
            filterInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    const filterValue = this.value.toLowerCase();
                    
                    rows.forEach(row => {
                        const cell = row.cells[index];
                        if (cell) {
                            const cellText = cell.textContent.toLowerCase();
                            const shouldShow = cellText.includes(filterValue);
                            row.style.display = shouldShow ? '' : 'none';
                        }
                    });
                });
            });
            
            // Initialize filtered export
            FilteredExport.initializeExportButton('applicationsTable', '{{ route("applications.export") }}');
        });
        
        function clearFilters() {
            FilteredExport.clearFilters('applicationsTable');
        }
    </script>
@endsection