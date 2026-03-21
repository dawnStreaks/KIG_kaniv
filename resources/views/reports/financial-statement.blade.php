@extends('layouts.app')

@section('title', 'Financial Statement')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $reportType ?? 'Financial' }} Statement</h2>
            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2 align-items-center">
                    <label class="small text-nowrap mb-0">From:</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
                    <label class="small text-nowrap mb-0">To:</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
                <a href="{{ route('reports.export-financial') }}" class="btn btn-success btn-sm">Export</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Opening Balance</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center {{ ($openingBalance ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format($openingBalance ?? 0, 3) }}
                        </h3>
                        <p class="text-center text-muted small mb-0">Balance before {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Collections</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-success">KWD {{ number_format($totalCollections ?? 0, 3) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Expenses</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-danger">KWD {{ number_format($totalExpenses ?? 0, 3) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Applications</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-danger">KWD {{ number_format($totalApplications ?? 0, 3) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Forwarded to Center</h5>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#forwardedDetails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-warning">KWD {{ number_format($totalForwarded ?? 0, 3) }}</h3>
                        <div class="collapse mt-3" id="forwardedDetails">
                            <table class="table table-sm">
                                <tr class="table-warning">
                                    <td><strong>Pending Receipt</strong></td>
                                    <td class="text-end"><strong>KWD {{ number_format(($totalForwarded ?? 0) - ($totalCollections ?? 0), 3) }}</strong></td>
                                </tr>
                                <tr class="table-info">
                                    <td><strong>Receipt Rate</strong></td>
                                    <td class="text-end"><strong>{{ ($totalForwarded ?? 0) > 0 ? number_format((($totalCollections ?? 0) / ($totalForwarded ?? 0)) * 100, 1) : 0 }}%</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Investments</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Invested:</td>
                                <td class="text-end">KWD {{ number_format($totalInvestments ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Income:</td>
                                <td class="text-end">KWD {{ number_format($totalIncome ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Returned:</td>
                                <td class="text-end">KWD {{ number_format($totalReturned ?? 0, 3) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Net Balance</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reports.area-summary') }}" class="btn btn-sm btn-outline-info">View Area Summary</a>
                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#netBalanceDetails">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $investedAmount = ($totalInvestments ?? 0) - ($totalReturned ?? 0);
                            $netBalance = ($openingBalance ?? 0) + ($totalCollections ?? 0) + ($totalIncome ?? 0) - ($totalExpenses ?? 0) - ($totalApplications ?? 0) - $investedAmount;
                        @endphp
                        <h3 class="text-center {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format($netBalance, 3) }}
                        </h3>
                        
                        <div class="collapse mt-3" id="netBalanceDetails">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr class="table-secondary">
                                        <td><strong>Opening Balance</strong></td>
                                        <td class="text-end"><strong>KWD {{ number_format($openingBalance ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Total Collections</strong></td>
                                        <td class="text-end"><strong>+ KWD {{ number_format($totalCollections ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Total Expenses</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($totalExpenses ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Total Applications</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($totalApplications ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Amount Invested (Net)</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($investedAmount, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Investment Income</strong></td>
                                        <td class="text-end"><strong>+ KWD {{ number_format($totalIncome ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Net Balance</strong></td>
                                        <td class="text-end"><strong>KWD {{ number_format($netBalance, 3) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
