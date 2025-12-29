@extends('layouts.app')

@section('title', 'Center Receive Collections')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Center Receive Collections</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <h5>Total Amount</h5>
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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Collection Date</th>
                                <th>Amount</th>
                                <th>Unit</th>
                                <th>Area</th>
                                <th>Mekhala</th>
                                <th>Entered By</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collections as $collection)
                                <tr>
                                    <td>{{ $collection->collection_date }}</td>
                                    <td>KWD {{ number_format($collection->amount, 3) }}</td>
                                    <td>{{ $collection->unit->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->unit->area->mekhala->name ?? 'N/A' }}</td>
                                    <td>{{ $collection->enteredBy->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($collection->collection_status === 'forwarded')
                                            <span class="badge bg-warning">Forwarded</span>
                                        @elseif($collection->collection_status === 'center_received')
                                            <span class="badge bg-success">Center Received</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($collection->collection_status === 'forwarded')
                                            <form method="POST" action="{{ route('collections.mark-center-received', $collection) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark as center received?')">
                                                    Center Receive
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No collections available for center receiving</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $collections->links() }}
            </div>
        </div>
    </div>
@endsection