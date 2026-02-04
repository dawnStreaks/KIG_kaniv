@extends('layouts.app')

@section('title', 'Financial Statement')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $reportType ?? 'Financial' }} Statement - {{ $currentYear ?? date('Y') }}/{{ $currentMonth ?? date('m') }}</h2>
            <div class="d-flex gap-2">
                <form method="GET" class="d-flex gap-2">
                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ ($currentYear ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ ($currentMonth ?? date('m')) == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('M', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
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
                        <p class="text-center text-muted small mb-0">Balance from previous months</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Collections Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Yearly Total Collections:</td>
                                <td class="text-end">KWD {{ number_format($yearlyCollections ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>This Month:</td>
                                <td class="text-end">KWD {{ number_format($monthlyCollections ?? 0, 3) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Expenses Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Yearly Total Expenses:</td>
                                <td class="text-end">KWD {{ number_format($yearlyExpenses ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>This Month:</td>
                                <td class="text-end">KWD {{ number_format($monthlyExpenses ?? 0, 3) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Applications Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Yearly Total Applications:</td>
                                <td class="text-end">KWD {{ number_format($yearlyApplications ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Monthly Total Applications:</td>
                                <td class="text-end">KWD {{ number_format($monthlyApplications ?? 0, 3) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Forwarded to Center</h5>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#forwardedDetails">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Yearly Forwarded:</td>
                                <td class="text-end">KWD {{ number_format($yearlyForwarded ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Monthly Forwarded:</td>
                                <td class="text-end">KWD {{ number_format($monthlyForwarded ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Yearly Received:</td>
                                <td class="text-end">KWD {{ number_format($yearlyCollections ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Monthly Received:</td>
                                <td class="text-end">KWD {{ number_format($monthlyCollections ?? 0, 3) }}</td>
                            </tr>
                        </table>
                        
                        <div class="collapse mt-3" id="forwardedDetails">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr class="table-warning">
                                        <td><strong>Pending Receipt</strong></td>
                                        <td class="text-end"><strong>KWD {{ number_format(($yearlyForwarded ?? 0) - ($yearlyCollections ?? 0), 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Receipt Rate</strong></td>
                                        <td class="text-end"><strong>{{ ($yearlyForwarded ?? 0) > 0 ? number_format((($yearlyCollections ?? 0) / ($yearlyForwarded ?? 0)) * 100, 1) : 0 }}%</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Other Income</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Amount Invested:</td>
                                <td class="text-end">KWD {{ number_format($yearlyInvestments ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Investment Income:</td>
                                <td class="text-end">KWD {{ number_format($yearlyIncome ?? 0, 3) }}</td>
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
                            $investedAmount = ($yearlyInvestments ?? 0) - ($yearlyReturned ?? 0);
                            $netBalance = ($yearlyCollections ?? 0) + ($yearlyIncome ?? 0) - ($yearlyExpenses ?? 0) - ($yearlyApplications ?? 0) - $investedAmount;
                        @endphp
                        <h3 class="text-center {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format($netBalance, 3) }}
                        </h3>
                        
                        <div class="collapse mt-3" id="netBalanceDetails">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr class="table-success">
                                        <td><strong>Total Collections</strong></td>
                                        <td class="text-end"><strong>+ KWD {{ number_format($yearlyCollections ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Total Expenses</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($yearlyExpenses ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Total Applications</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($yearlyApplications ?? 0, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>Amount Invested (Net)</strong></td>
                                        <td class="text-end"><strong>- KWD {{ number_format($investedAmount, 3) }}</strong></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Other Income</strong></td>
                                        <td class="text-end"><strong>+ KWD {{ number_format($yearlyIncome ?? 0, 3) }}</strong></td>
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