@extends('layouts.app')

@section('title', 'Application Payment Report')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Application Payment Report - {{ $currentYear ?? date('Y') }}/{{ $currentMonth ?? date('m') }}</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.application-payment') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year</label>
                            <select name="year" id="year" class="form-select">
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ ($currentYear ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="month" class="form-label">Month</label>
                            <select name="month" id="month" class="form-select">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}" {{ ($currentMonth ?? date('m')) == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('M', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="medical_support" {{ request('category') == 'medical_support' ? 'selected' : '' }}>Medical Support</option>
                                <option value="financial_support" {{ request('category') == 'financial_support' ? 'selected' : '' }}>Financial Support</option>
                                <option value="iqama_visa_residency" {{ request('category') == 'iqama_visa_residency' ? 'selected' : '' }}>Iqama/Visa/Residency</option>
                                <option value="ticket" {{ request('category') == 'ticket' ? 'selected' : '' }}>Ticket</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('reports.application-payment') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h5>Total Applications ({{ $currentYear ?? date('Y') }}/{{ $currentMonth ?? date('m') }})</h5>
                        <h3 class="text-primary">{{ $applications->count() }}</h3>
                    </div>
                    <div class="col-md-6">
                        <h5>Total Amount</h5>
                        <h3 class="text-success">KWD {{ number_format($totalAmount, 3) }}</h3>
                    </div>
                </div>
            </div>
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
                                <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Categories</option><option value="medical_support">Medical Support</option><option value="financial_support">Financial Support</option><option value="iqama_visa_residency">Iqama/Visa/Residency</option><option value="ticket">Ticket</option></select></th>
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
                                    <td>{{ ucfirst(str_replace('_', ' ', $application->category)) }}</td>
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