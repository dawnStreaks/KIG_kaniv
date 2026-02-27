@extends('layouts.app')

@section('title', 'Opening Balance')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Opening Balance</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.opening-balance.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control" required>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mekhala</label>
                        <select name="mekhala_id" class="form-control">
                            <option value="">All (Combined)</option>
                            @foreach($mekhalas as $mekhala)
                                <option value="{{ $mekhala->id }}">{{ $mekhala->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Amount (KWD)</label>
                        <input type="number" name="amount" class="form-control" step="0.001" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Opening Balance</button>
            </form>

            <hr class="my-4">

            <h5>Existing Opening Balances</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Mekhala</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($openingBalances as $balance)
                    <tr>
                        <td>{{ $balance->year }}</td>
                        <td>{{ $balance->mekhala->name ?? 'All (Combined)' }}</td>
                        <td>KWD {{ number_format($balance->amount, 3) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.opening-balance.destroy', $balance) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this opening balance?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
