<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $reportType ?? 'Financial' }} Statement</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #212529; }
        .header-table { width: 100%; margin-bottom: 6px; }
        .header-table td { vertical-align: middle; }
        .header-logo { width: 90px; }
        .header-logo img { max-width: 90px; max-height: 60px; }
        .header-title { text-align: center; }
        .header-title h1 { font-size: 20px; margin: 0; }
        .header-title p { font-size: 11px; color: #6c757d; margin: 2px 0 0; }
        hr { border: none; border-top: 2px solid #333; margin: 4px 0 14px; }

        .cards { width: 100%; border-collapse: separate; border-spacing: 8px; margin-bottom: 4px; }
        .cards td { width: 33.33%; vertical-align: top; }
        .card { border: 1px solid #dee2e6; border-radius: 4px; }
        .card-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 6px 10px; font-weight: bold; font-size: 13px; }
        .card-body { padding: 10px; }
        .card-total { text-align: center; font-size: 18px; font-weight: bold; margin: 4px 0 8px; }
        .text-success { color: #198754; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #b8860b; }
        .text-muted { color: #6c757d; font-size: 10px; text-align: center; }

        table.detail { width: 100%; border-collapse: collapse; font-size: 11px; }
        table.detail td { padding: 3px 4px; border-bottom: 1px solid #f1f1f1; }
        table.detail td.amount { text-align: right; white-space: nowrap; }
        table.detail tr.subtotal td { font-weight: bold; background: #f8f9fa; }
        table.detail table.sub { width: 100%; margin-left: 10px; }
        table.detail table.sub td { border-bottom: 1px dotted #eee; color: #444; }

        .net-balance { border: 1px solid #dee2e6; border-radius: 4px; margin-top: 8px; }
        .net-balance .card-total { font-size: 22px; }
        .net-balance table.detail tr td:first-child { font-weight: bold; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-logo" style="text-align: left;">
                <img src="{{ public_path('logos/kig_logo_sm.jpeg') }}">
            </td>
            <td class="header-title">
                <h1>{{ $reportType ?? 'Financial' }} Statement</h1>
                <p>{{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</p>
            </td>
            <td class="header-logo" style="text-align: right;">
                <img src="{{ public_path('logos/kaniv.png') }}">
            </td>
        </tr>
    </table>
    <hr>

    <table class="cards">
        <tr>
            <td>
                <div class="card">
                    <div class="card-header">Opening Balance</div>
                    <div class="card-body">
                        <div class="card-total {{ ($openingBalance ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            KWD {{ number_format($openingBalance ?? 0, 3) }}
                        </div>
                        <div class="text-muted">Balance before {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}</div>
                    </div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-header">Collections</div>
                    <div class="card-body">
                        <div class="card-total text-success">KWD {{ number_format($totalCollections ?? 0, 3) }}</div>
                        <table class="detail">
                            @forelse($collectionsByType ?? [] as $type => $total)
                            <tr>
                                <td>{{ ucfirst($type) }}</td>
                                <td class="amount">KWD {{ number_format($total, 3) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">No collections in this period</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-header">Expenses</div>
                    <div class="card-body">
                        <div class="card-total text-danger">KWD {{ number_format($totalExpenses ?? 0, 3) }}</div>
                        <table class="detail">
                            @forelse($expensesByCategory ?? [] as $category => $categoryData)
                            <tr class="subtotal">
                                <td>{{ $category }}</td>
                                <td class="amount">KWD {{ number_format($categoryData['total'], 3) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table class="sub">
                                        @foreach($categoryData['types'] as $type => $amount)
                                        <tr>
                                            <td>{{ $type }}</td>
                                            <td class="amount">KWD {{ number_format($amount, 3) }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">No expenses in this period</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="cards">
        <tr>
            <td>
                <div class="card">
                    <div class="card-header">Applications</div>
                    <div class="card-body">
                        <div class="card-total text-danger">KWD {{ number_format($totalApplications ?? 0, 3) }}</div>
                        <table class="detail">
                            @forelse($applicationsByCategory ?? [] as $category => $total)
                            <tr>
                                <td>{{ $category }}</td>
                                <td class="amount">KWD {{ number_format($total, 3) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-muted">No paid applications in this period</td></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-header">Forwarded to Center</div>
                    <div class="card-body">
                        <div class="card-total text-warning">KWD {{ number_format($totalForwarded ?? 0, 3) }}</div>
                        <table class="detail">
                            <tr class="subtotal">
                                <td>Pending Receipt</td>
                                <td class="amount">KWD {{ number_format(($totalForwarded ?? 0) - ($totalCollections ?? 0), 3) }}</td>
                            </tr>
                            <tr class="subtotal">
                                <td>Receipt Rate</td>
                                <td class="amount">{{ ($totalForwarded ?? 0) > 0 ? number_format((($totalCollections ?? 0) / ($totalForwarded ?? 0)) * 100, 1) : 0 }}%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-header">Investments</div>
                    <div class="card-body">
                        <table class="detail">
                            <tr><td>Invested</td><td class="amount">KWD {{ number_format($totalInvestments ?? 0, 3) }}</td></tr>
                            <tr><td>Income</td><td class="amount">KWD {{ number_format($totalIncome ?? 0, 3) }}</td></tr>
                            <tr><td>Returned</td><td class="amount">KWD {{ number_format($totalReturned ?? 0, 3) }}</td></tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    @php
        $investedAmount = ($totalInvestments ?? 0) - ($totalReturned ?? 0);
        $netBalance = ($openingBalance ?? 0) + ($totalCollections ?? 0) + ($totalIncome ?? 0) - ($totalExpenses ?? 0) - ($totalApplications ?? 0) - $investedAmount;
    @endphp
    <div class="net-balance">
        <div class="card-header">Net Balance</div>
        <div class="card-body">
            <div class="card-total {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}">KWD {{ number_format($netBalance, 3) }}</div>
            <table class="detail">
                <tr><td>Opening Balance</td><td class="amount">KWD {{ number_format($openingBalance ?? 0, 3) }}</td></tr>
                <tr><td>Total Collections</td><td class="amount">+ KWD {{ number_format($totalCollections ?? 0, 3) }}</td></tr>
                <tr><td>Total Expenses</td><td class="amount">- KWD {{ number_format($totalExpenses ?? 0, 3) }}</td></tr>
                <tr><td>Total Applications</td><td class="amount">- KWD {{ number_format($totalApplications ?? 0, 3) }}</td></tr>
                <tr><td>Amount Invested (Net)</td><td class="amount">- KWD {{ number_format($investedAmount, 3) }}</td></tr>
                <tr><td>Investment Income</td><td class="amount">+ KWD {{ number_format($totalIncome ?? 0, 3) }}</td></tr>
                <tr class="subtotal"><td>Net Balance</td><td class="amount">KWD {{ number_format($netBalance, 3) }}</td></tr>
            </table>
        </div>
    </div>
</body>
</html>
