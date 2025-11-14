@extends('layouts.app')

@section('title', 'Application Payment Report')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Application Payment Report</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Approved Amount</th>
                                <th>Expense Amount</th>
                                <th>Approved Date</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter ID" data-column="0"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Name" data-column="1"></th>
                                <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Categories</option><option value="health">Health</option><option value="finance">Finance</option></select></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="3"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Expense" data-column="4"></th>
                                <th><input type="date" class="form-control form-control-sm filter-input" data-column="5"></th>
                                <th><select class="form-control form-control-sm filter-input" data-column="6"><option value="">All Status</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>{{ $application->name }}</td>
                                    <td>{{ ucfirst($application->category) }}</td>
                                    <td>KWD {{ number_format($application->approved_amount, 3) }}</td>
                                    <td>KWD {{ number_format($application->expense_amount, 3) }}</td>
                                    <td>{{ $application->approved_date ? $application->approved_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No applications found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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