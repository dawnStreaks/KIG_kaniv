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
                <form method="GET" id="filterForm">
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
                            <th><input type="text" class="form-control form-control-sm" name="amount" placeholder="Filter Amount" value="{{ request('amount') }}"></th>
                            <th><div class="d-flex gap-1"><input type="date" class="form-control form-control-sm" name="date_from" value="{{ request('date_from') }}"><input type="date" class="form-control form-control-sm" name="date_to" value="{{ request('date_to') }}"></div></th>
                            <th><select class="form-control form-control-sm" name="unit"><option value="">All Units</option>@foreach($allUnits as $unit)<option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>@endforeach</select></th>
                            <th><select class="form-control form-control-sm" name="term"><option value="">All Terms</option>@foreach($allTerms as $term)<option value="{{ $term }}" {{ request('term') == $term ? 'selected' : '' }}>{{ $term }}</option>@endforeach</select></th>
                            <th><select class="form-control form-control-sm" name="type"><option value="">All Types</option>@foreach($allTypes as $type)<option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>@endforeach</select></th>
                            <th><input type="text" class="form-control form-control-sm" name="user" placeholder="Filter User" value="{{ request('user') }}"></th>
                            <th></th>
                        </tr>
                    </thead>
                </form>
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
                                @if(auth()->user()->isCenterUser() && $collection->collection_status === 'forwarded')
                                    <form method="POST" action="{{ route('collections.mark-center-received', $collection) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark as center received?')">
                                            Center Receive
                                        </button>
                                    </form>
                                @elseif(auth()->user()->isCenterUser())
                                    @if($collection->collection_status === 'received')
                                        <span class="text-muted">Mekhala Received</span>
                                    @elseif($collection->collection_status === 'forwarded')
                                        <span class="text-muted">Forwarded</span>
                                    @elseif($collection->collection_status === 'center_received')
                                        <span class="text-muted">Center Received</span>
                                    @else
                                        <span class="text-muted">Payable</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
            </div>
            
            {{ $collections->links('pagination.custom') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
        
        function clearFilters() {
            window.location.href = '{{ route('collections.index') }}';
        }
    </script>
@endsection