@extends('layouts.app')

@section('title', 'Receive Collections')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Receive Collections</h2>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table" id="receiveCollectionsTable">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Area</th>
                            <th>Amount</th>
                            <th>Collection Date</th>
                            <th>Type</th>
                            <th>Term</th>
                            <th>Status</th>
                            <th>Entered By</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Unit" data-column="0"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Area" data-column="1"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="2"></th>
                            <th><input type="date" class="form-control form-control-sm filter-input" data-column="3"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Type" data-column="4"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Term" data-column="5"></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="6"><option value="">All Status</option><option value="payable">Payable</option><option value="received">Received</option></select></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="7"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $collection)
                        <tr>
                            <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                            <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                            <td>KWD {{ number_format($collection->amount, 2) }}</td>
                            <td>{{ $collection->collection_date }}</td>
                            <td>{{ ucfirst($collection->type) }}</td>
                            <td>{{ ucfirst($collection->term) }}</td>
                            <td>
                                @if($collection->collection_status === 'received')
                                    <span class="badge bg-success">Received</span>
                                @else
                                    <span class="badge bg-warning">Payable</span>
                                @endif
                            </td>
                            <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                            <td>
                                @if($collection->collection_status === 'payable')
                                    <form method="POST" action="{{ route('collections.mark-received', $collection) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Mark this collection as received?')">
                                            Receive Collection
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Already Received</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $collections->links() }}
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
            });
            filterTable();
        }
    </script>
@endsection