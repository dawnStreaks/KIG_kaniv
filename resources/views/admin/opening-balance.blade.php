@extends('layouts.app')

@section('title', 'Opening Balance')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Opening Balance</h2>
    </div>

    <div class="alert alert-info">
        <strong>Note:</strong> Enter the opening balance for a specific month. This is a one-time entry that will be added to the calculated balance in financial reports. For example, entering KWD 1000 for January 2026 means that amount will be included in the opening balance for any report starting from February 2026 onwards.
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>East Mekhala Opening Balance</h5>
                    <form method="POST" action="{{ route('admin.opening-balance.store') }}">
                        @csrf
                        <input type="hidden" name="mekhala_id" value="1">
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
                                <label class="form-label">Month</label>
                                <select name="month" class="form-control" required>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount (KWD)</label>
                                <input type="number" name="amount" class="form-control" step="0.001" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    
                    <hr class="my-3">
                    
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eastBalances as $balance)
                            <tr>
                                <td>{{ $balance->year }}</td>
                                <td>{{ $balance->month ? date('F', mktime(0, 0, 0, $balance->month, 1)) : 'N/A' }}</td>
                                <td>KWD {{ number_format($balance->amount, 3) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.opening-balance.destroy', $balance) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h5>West Mekhala Opening Balance</h5>
                    <form method="POST" action="{{ route('admin.opening-balance.store') }}">
                        @csrf
                        <input type="hidden" name="mekhala_id" value="2">
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
                                <label class="form-label">Month</label>
                                <select name="month" class="form-control" required>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount (KWD)</label>
                                <input type="number" name="amount" class="form-control" step="0.001" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    
                    <hr class="my-3">
                    
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($westBalances as $balance)
                            <tr>
                                <td>{{ $balance->year }}</td>
                                <td>{{ $balance->month ? date('F', mktime(0, 0, 0, $balance->month, 1)) : 'N/A' }}</td>
                                <td>KWD {{ number_format($balance->amount, 3) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.opening-balance.destroy', $balance) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
