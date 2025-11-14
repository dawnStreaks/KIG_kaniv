@extends('layouts.app')

@section('title', 'Review Applications')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Applications Review</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Approved Amount</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Submitted Date</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Name" data-column="0"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="1"></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Categories</option><option value="medical_support">Medical Support</option><option value="financial_support">Financial Support</option><option value="iqama_visa_residency">Iqama/Visa/Residency</option><option value="ticket">Ticket</option></select></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="3"><option value="">All Status</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select></th>
                            <th><input type="date" class="form-control form-control-sm filter-input" data-column="4"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->name }}</td>
                            <td>KWD {{ number_format($application->approved_amount, 3) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $application->category)) }}</td>
                            <td>
                                <span class="badge bg-{{ $application->status == 'pending' ? 'warning' : ($application->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if($application->status == 'pending' && auth()->user()->canApproveApplications())
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $application->id }}">Approve</button>
                                    <form method="POST" action="{{ route('applications.reject', $application->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @else
                                    <span class="text-muted">{{ ucfirst($application->status) }}</span>
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
                        @endforeach
                    </tbody>
                </table>
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
            const filterInputs = document.querySelectorAll('.filter-input');
            const tableRows = document.querySelectorAll('tbody tr');
            
            filterInputs.forEach(input => {
                input.addEventListener('input', function() {
                    filterTable();
                });
            });
            
            function filterTable() {
                tableRows.forEach(row => {
                    let showRow = true;
                    
                    filterInputs.forEach(input => {
                        const column = input.dataset.column;
                        const filterValue = input.value.toLowerCase();
                        const cellValue = row.cells[column].textContent.toLowerCase();
                        
                        if (filterValue && !cellValue.includes(filterValue)) {
                            showRow = false;
                        }
                    });
                    
                    row.style.display = showRow ? '' : 'none';
                });
            }
        });
        
        function clearFilters() {
            const filterInputs = document.querySelectorAll('.filter-input');
            filterInputs.forEach(input => {
                input.value = '';
                input.dispatchEvent(new Event('input'));
            });
        }
    </script>
@endsection