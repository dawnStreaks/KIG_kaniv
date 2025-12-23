@extends('layouts.app')

@section('title', 'Receive Collections')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Receive Collections</h2>
            <div>
                <button type="button" class="btn btn-primary me-2" id="bulkReceiveBtn" onclick="bulkReceive()" disabled>Bulk Receive</button>
                <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table" id="receiveCollectionsTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
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
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Unit" data-column="1"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Area" data-column="2"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Amount" data-column="3"></th>
                            <th><input type="date" class="form-control form-control-sm filter-input" data-column="4"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Type" data-column="5"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter Term" data-column="6"></th>
                            <th><select class="form-control form-control-sm filter-input" data-column="7"><option value="">All Status</option><option value="payable">Payable</option><option value="received">Received</option><option value="forwarded">Forwarded</option></select></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Filter User" data-column="8"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $collection)
                        <tr>
                            <td>
                                @if($collection->collection_status === 'payable')
                                    <input type="checkbox" class="collection-checkbox" value="{{ $collection->id }}" onchange="updateBulkButton()">
                                @endif
                            </td>
                            <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                            <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                            <td>KWD {{ number_format($collection->amount, 3) }}</td>
                            <td>{{ $collection->collection_date }}</td>
                            <td>{{ ucfirst($collection->type) }}</td>
                            <td>{{ ucfirst($collection->term) }}</td>
                            <td>
                                @if($collection->collection_status === 'received')
                                    <span class="badge bg-success">Received</span>
                                @elseif($collection->collection_status === 'forwarded')
                                    <span class="badge bg-info">Forwarded</span>
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
                                @elseif($collection->collection_status === 'received')
                                    <form method="POST" action="{{ route('collections.forward-to-center', $collection) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-info" onclick="return confirm('Forward this collection to center?')">
                                            Forward to Center
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Forwarded to Center</span>
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
        
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.collection-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            updateBulkButton();
        }
        
        function updateBulkButton() {
            const checkedBoxes = document.querySelectorAll('.collection-checkbox:checked');
            const bulkBtn = document.getElementById('bulkReceiveBtn');
            
            bulkBtn.disabled = checkedBoxes.length === 0;
            bulkBtn.textContent = `Bulk Receive (${checkedBoxes.length})`;
        }
        
        function bulkReceive() {
            const checkedBoxes = document.querySelectorAll('.collection-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                alert('Please select collections to receive');
                return;
            }
            
            if (!confirm(`Mark ${checkedBoxes.length} collections as received?`)) {
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('collections.bulk-receive') }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'collection_ids[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection