@extends('layouts.app')

@section('title', 'Area Summary with Detailed Transactions')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Area Summary with Detailed Transactions</h2>
            <a href="{{ route('reports.financial') }}" class="btn btn-secondary">Back to Financial Statement</a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Area Summary with Detailed Transactions</h5>
                <small class="text-muted">Showing data for {{ date('F Y', mktime(0, 0, 0, $currentMonth ?? date('m'), 1, $currentYear ?? date('Y'))) }}</small>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select name="year" class="form-select form-select-sm">
                                @for($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ ($currentYear ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select form-select-sm">
                                <option value="">All Types</option>
                                @foreach($types ?? [] as $typeOption)
                                    <option value="{{ $typeOption }}" {{ ($type ?? '') == $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="term" class="form-select form-select-sm">
                                <option value="">All Terms</option>
                                @foreach($terms ?? [] as $termOption)
                                    <option value="{{ $termOption }}" {{ ($term ?? '') == $termOption ? 'selected' : '' }}>{{ $termOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Area</th>
                                <th class="text-end">Collections</th>
                                <th class="text-end">Expenses</th>
                                <th class="text-end">Balance</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areaSummary as $index => $summary)
                            <tr>
                                <td><strong>{{ $summary['area'] }}</strong></td>
                                <td class="text-end">KWD {{ number_format($summary['collections'], 3) }}</td>
                                <td class="text-end">KWD {{ number_format($summary['expenses'], 3) }}</td>
                                <td class="text-end {{ $summary['balance'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    <strong>KWD {{ number_format($summary['balance'], 3) }}</strong>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#areaDetails{{ $index }}">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="p-0">
                                    <div class="collapse" id="areaDetails{{ $index }}">
                                        <div class="p-3 bg-light">
                                            <h6>{{ $summary['area'] }} - Detailed Transactions</h6>
                                            @if(isset($groupedTransactions[$summary['area']]))
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th class="text-end">Collection</th>
                                                            <th class="text-end">Expense</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($groupedTransactions[$summary['area']] as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction['date'] }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $transaction['type'] == 'Collection' ? 'success' : 'danger' }}">
                                                                    {{ $transaction['type'] }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $transaction['description'] }}</td>
                                                            <td class="text-end">
                                                                {{ $transaction['collection'] > 0 ? 'KWD ' . number_format($transaction['collection'], 3) : '-' }}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ $transaction['expense'] > 0 ? 'KWD ' . number_format($transaction['expense'], 3) : '-' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <p class="text-muted mb-0">No transactions found for this area.</p>
                                            @endif
                                        </div>
                                    </div>
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