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

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Collection Date</th>
                            <th>Unit</th>
                            <th>Entered By</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="0"></th>
                            <th><input type="date" class="form-control form-control-sm filter-input" data-column="1"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Unit" data-column="2"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="3"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $collection)
                        <tr>
                            <td>KWD {{ number_format($collection->amount, 2) }}</td>
                            <td>{{ $collection->collection_date }}</td>
                            <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                            <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/filtered-export.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (!table.id) table.id = 'collectionsTable';
            
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
            FilteredExport.initializeExportButton('collectionsTable', '{{ route("collections.export") }}');
        });
        
        function clearFilters() {
            FilteredExport.clearFilters('collectionsTable');
        }
    </script>
@endsection