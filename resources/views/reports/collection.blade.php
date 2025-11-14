@extends('layouts.app')

@section('title', 'Collection Report')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Collection Report</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Collection Date</th>
                                <th>Amount</th>
                                <th>Unit</th>
                                <th>Mekhala</th>
                                <th>Area</th>
                                <th>Notes</th>
                                <th>Entered By</th>
                                <th>Created At</th>
                            </tr>
                            <tr>
                                <th><input type="date" class="form-control form-control-sm filter-input" data-column="0"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="1"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Unit" data-column="2"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Mekhala" data-column="3"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Area" data-column="4"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Notes" data-column="5"></th>
                                <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="6"></th>
                                <th><input type="date" class="form-control form-control-sm filter-input" data-column="7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collections as $collection)
                                <tr>
                                    <td>{{ $collection->collection_date }}</td>
                                    <td>KWD {{ number_format($collection->amount, 3) }}</td>
                                    <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->mekhala->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->notes ?? 'N/A' }}</td>
                                    <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No collections found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th>Total:</th>
                                <th id="totalAmount">KWD {{ number_format($collections->sum('amount'), 3) }}</th>
                                <th colspan="6"></th>
                            </tr>
                        </tfoot>
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
                let visibleTotal = 0;
                
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
                    
                    if (showRow) {
                        const amountText = row.cells[1].textContent.replace('KWD ', '').replace(',', '');
                        const amount = parseFloat(amountText) || 0;
                        visibleTotal += amount;
                    }
                });
                
                document.getElementById('totalAmount').textContent = 'KWD ' + visibleTotal.toLocaleString('en-US', {minimumFractionDigits: 3, maximumFractionDigits: 3});
            }
        });
        
        function clearFilters() {
            const filterInputs = document.querySelectorAll('.filter-input');
            filterInputs.forEach(input => {
                input.value = '';
            });
            filterTable();
        }
    </script>
@endsection