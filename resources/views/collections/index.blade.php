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

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="amount" class="form-control" placeholder="Filter Amount" value="{{ request('amount') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="collection_date" class="form-control" value="{{ request('collection_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="unit" class="form-control" placeholder="Filter Unit" value="{{ request('unit') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="term" class="form-control" placeholder="Filter Term" value="{{ request('term') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="type" class="form-control" placeholder="Filter Type" value="{{ request('type') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>

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


@endsection