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

        <div class="card mb-3">
            <div class="card-header">
                <h5>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('collections.receive') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" id="unit" class="form-select form-select-sm">
                                <option value="">All Units</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="area" class="form-label">Area</label>
                            <select name="area" id="area" class="form-select form-select-sm">
                                <option value="">All Areas</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-type" class="form-label">Type</label>
                            <select name="type" id="filter-type" class="form-select form-select-sm">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter-term" class="form-label">Term</label>
                            <select name="term" id="filter-term" class="form-select form-select-sm">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term }}" {{ request('term') == $term ? 'selected' : '' }}>{{ $term }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="payable" {{ request('status') == 'payable' ? 'selected' : '' }}>Payable</option>
                                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="forwarded" {{ request('status') == 'forwarded' ? 'selected' : '' }}>Forwarded</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                            <a href="{{ route('collections.receive') }}" class="btn btn-secondary btn-sm">Clear</a>
                        </div>
                    </div>
                </form>
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
                                    <span class="badge bg-success">Mekhala Received</span>
                                @elseif($collection->collection_status === 'forwarded')
                                    <span class="badge bg-info">Forwarded</span>
                                @elseif($collection->collection_status === 'center_received')
                                    <span class="badge bg-primary">Center Received</span>
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
                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Mark this collection as mekhala received?')">
                                            Mekhala Receive
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
                                    <span class="text-muted">Mekhala Received</span>
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

    <script src="{{ asset('js/term-type-filter.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initTermTypeFilter('filter-type', 'filter-term', '{{ route("api.terms-by-type") }}', '{{ request("term") }}');
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