@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Expenses</h2>
            <div>
                <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">Clear Filters</button>
                <a href="{{ route('expenses.export') }}" class="btn btn-success me-2">Export Excel</a>
                @if(auth()->user()->canAddExpenses())
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add Expense</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Particulars</th>
                            <th>Type</th>
                            <th>Expense Date</th>
                            <th>Beneficiary</th>
                            <th>Paid By</th>
                            <th>Bill</th>
                            <th>Entered By</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="0"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Particulars" data-column="1"></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Types</option>@foreach($expenseTypes as $type)<option value="{{ $type }}">{{ $type }}</option>@endforeach</select></th>
                            <th><input type="date" class="form-control form-control-sm filter-input" data-column="3"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Beneficiary" data-column="4"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Paid By" data-column="5"></th>
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="7"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>KWD {{ number_format($expense->amount, 3) }}</td>
                            <td>{{ $expense->particulars }}</td>
                            <td>{{ ucfirst($expense->type) }}</td>
                            <td>{{ $expense->expense_date }}</td>
                            <td>{{ $expense->beneficiary ?? '-' }}</td>
                            <td>{{ $expense->paidByArea->name ?? '-' }}</td>
                            <td>
                                @if($expense->bill_path)
                                    <a href="{{ route('expenses.view-bill', $expense) }}" target="_blank" class="btn btn-sm btn-info">View Bill</a>
                                @else
                                    <span class="text-muted">No bill</span>
                                @endif
                            </td>
                            <td>{{ $expense->enteredBy->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $expenses->links('pagination.custom') }}
        </div>
    </div>

    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'expensesTable';
            
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
            
            // Initialize filtered export
            FilteredExport.initializeExportButton('expensesTable', '{{ route("expenses.export") }}');
        });
        
        function clearFilters() {
            FilteredExport.clearFilters('expensesTable');
        }
    </script>
@endsection