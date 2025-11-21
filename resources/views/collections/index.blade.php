@extends('layouts.app')

@section('title', 'Collections')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Collections</h2>
            <div>
                <button type="button" class="btn btn-secondary me-2" onclick="clearFilters()">Clear Filters</button>
                <a href="{{ route('collections.export') }}" class="btn btn-success me-2">Export Excel</a>
                <a href="{{ route('collections.create') }}" class="btn btn-primary">Add Collection</a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h5>Total Collections</h5>
                        <h3 class="text-primary">KWD {{ number_format($totalAmount, 3) }}</h3>
                    </div>
                    <div class="col-md-6">
                        <h5>Total Records</h5>
                        <h3 class="text-info">{{ $collections->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Collection Date</th>
                            <th>Unit</th>
                            <th>Term</th>
                            <th>Type</th>
                            <th>Entered By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="0"></th>
                            <th><div class="d-flex gap-1"><input type="date" class="form-control form-control-sm date-from" placeholder="From" data-column="1"><input type="date" class="form-control form-control-sm date-to" placeholder="To" data-column="1"></div></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="2"><option value="">All Units</option>@foreach($allUnits as $unit)<option value="{{ $unit }}">{{ $unit }}</option>@endforeach</select></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="3"><option value="">All Terms</option>@foreach($allTerms as $term)<option value="{{ $term }}">{{ $term }}</option>@endforeach</select></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="4"><option value="">All Types</option>@foreach($allTypes as $type)<option value="{{ $type }}">{{ $type }}</option>@endforeach</select></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="5"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $collection)
                        <tr>
                            <td>KWD {{ number_format($collection->amount, 3) }}</td>
                            <td>{{ $collection->collection_date }}</td>
                            <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                            <td>{{ $collection->term ?? 'N/A' }}</td>
                            <td>{{ $collection->type ?? 'N/A' }}</td>
                            <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $collections->links('pagination.custom') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = document.querySelectorAll('.filter-input');
            const dateFromInput = document.querySelector('.date-from');
            const dateToInput = document.querySelector('.date-to');
            const tableRows = document.querySelectorAll('tbody tr');
            
            filterInputs.forEach(input => {
                input.addEventListener('input', function() {
                    filterTable();
                });
                input.addEventListener('change', function() {
                    filterTable();
                });
            });
            
            if (dateFromInput && dateToInput) {
                dateFromInput.addEventListener('change', filterTable);
                dateToInput.addEventListener('change', filterTable);
            }
            
            function filterTable() {
                tableRows.forEach(row => {
                    let showRow = true;
                    
                    // Date range filter
                    if (dateFromInput && dateToInput) {
                        const fromDate = dateFromInput.value;
                        const toDate = dateToInput.value;
                        const cellDate = row.cells[1].textContent.trim();
                        
                        if (fromDate && cellDate < fromDate) {
                            showRow = false;
                        }
                        if (toDate && cellDate > toDate) {
                            showRow = false;
                        }
                    }
                    
                    filterInputs.forEach(input => {
                        const column = parseInt(input.dataset.column);
                        const filterValue = input.value.toLowerCase().trim();
                        
                        if (filterValue && row.cells[column] && column !== 1) { // Skip column 1 (date) as it's handled above
                            const cellValue = row.cells[column].textContent.toLowerCase().trim();
                            
                            if (input.tagName === 'SELECT') {
                                if (cellValue !== filterValue.toLowerCase()) {
                                    showRow = false;
                                }
                            } else if (!cellValue.includes(filterValue)) {
                                showRow = false;
                            }
                        }
                    });
                    
                    row.style.display = showRow ? '' : 'none';
                });
            }
        });
        
        function clearFilters() {
            const filterInputs = document.querySelectorAll('.filter-input');
            const dateFromInput = document.querySelector('.date-from');
            const dateToInput = document.querySelector('.date-to');
            
            filterInputs.forEach(input => {
                input.value = '';
            });
            
            if (dateFromInput) dateFromInput.value = '';
            if (dateToInput) dateToInput.value = '';
            
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = '';
            });
        }
    </script>
@endsection