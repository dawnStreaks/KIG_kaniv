@extends('layouts.app')

@section('title', 'Financial Statement')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Financial Statement</h2>
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
                                <td>Total Collections:</td>
                                <td class="text-end">KWD {{ number_format($totalCollections ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>This Month:</td>
                                <td class="text-end">KWD {{ number_format($monthlyCollections ?? 0, 2) }}</td>
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
                                <td>Total Expenses:</td>
                                <td class="text-end">KWD {{ number_format($totalExpenses ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>This Month:</td>
                                <td class="text-end">KWD {{ number_format($monthlyExpenses ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Net Balance</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center {{ (($totalCollections ?? 0) - ($totalExpenses ?? 0)) >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format(($totalCollections ?? 0) - ($totalExpenses ?? 0), 2) }}
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
                                            {{ $transaction['collection'] > 0 ? 'KWD ' . number_format($transaction['collection'], 2) : '-' }}
                                        </td>
                                        <td class="text-end">
                                            {{ $transaction['expense'] > 0 ? 'KWD ' . number_format($transaction['expense'], 2) : '-' }}
                                        </td>
                                        <td class="text-end {{ $transaction['balance'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            KWD {{ number_format($transaction['balance'], 2) }}
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