@extends('layouts.app')

@section('title', 'Receive Collections')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Receive Collections</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
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
@endsection