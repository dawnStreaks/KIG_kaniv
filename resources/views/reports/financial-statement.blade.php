@extends('layouts.app')

@section('title', 'Financial Statement')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $reportType ?? 'Financial' }} Statement</h2>
            <a href="{{ route('reports.export-financial') }}" class="btn btn-success">Export</a>
        </div>

        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
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
            @if(!$mekhalaName)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Investment Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Yearly Total Investments:</td>
                                <td class="text-end">KWD {{ number_format($yearlyInvestments ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Monthly Total Investments:</td>
                                <td class="text-end">KWD {{ number_format($monthlyInvestments ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Income Generated:</td>
                                <td class="text-end">KWD {{ number_format($yearlyIncome ?? 0, 3) }}</td>
                            </tr>
                            <tr>
                                <td>Capital Returned:</td>
                                <td class="text-end">KWD {{ number_format($yearlyReturned ?? 0, 3) }}</td>
                            </tr>
                            <tr class="table-info">
                                <td><strong>Investment Balance:</strong></td>
                                <td class="text-end"><strong>KWD {{ number_format(($yearlyInvestments ?? 0) + ($yearlyIncome ?? 0) - ($yearlyReturned ?? 0), 3) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Net Balance</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $netBalance = ($yearlyCollections ?? 0) - ($yearlyExpenses ?? 0) - ($yearlyApplications ?? 0);
                        @endphp
                        <h3 class="text-center {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format($netBalance, 3) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Detailed Financial Statement</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th class="text-end">Collection</th>
                                        <th class="text-end">Expense</th>
                                        <th class="text-end">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
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
                                        <td class="text-end {{ $transaction['balance'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            KWD {{ number_format($transaction['balance'], 3) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection