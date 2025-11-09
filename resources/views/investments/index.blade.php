@extends('layouts.app')

@section('title', 'Investments')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Investments</h2>
            <div>
                @if(auth()->user()->canAddInvestments())
                    <a href="{{ route('investments.create') }}" class="btn btn-primary">Add Investment</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Income Generated</th>
                            <th>Status</th>
                            <th>Balance</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investments as $investment)
                        <tr>
                            <td>{{ $investment->investment_date }}</td>
                            <td>KWD {{ number_format($investment->amount, 2) }}</td>
                            <td>{{ $investment->description }}</td>
                            <td>KWD {{ number_format($investment->income_generated, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $investment->status === 'approved' ? 'success' : ($investment->status === 'capital_returned' ? 'info' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $investment->status)) }}
                                </span>
                            </td>
                            <td>KWD {{ number_format($investment->balance, 2) }}</td>
                            <td>{{ $investment->creator->name ?? 'N/A' }}</td>
                            <td>
                                @if(auth()->user()->canAddInvestments())
                                    <button class="btn btn-sm btn-success" onclick="addIncome({{ $investment->id }})">Add Income</button>
                                    @if($investment->status === 'approved')
                                        <button class="btn btn-sm btn-info" onclick="returnCapital({{ $investment->id }})">Return Capital</button>
                                    @endif
                                @endif
                                @if(auth()->user()->user_type === 'center' && $investment->status === 'pending')
                                    <form method="POST" action="{{ route('investments.approve', $investment) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Income Modal -->
    <div class="modal fade" id="addIncomeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Income</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addIncomeForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="income" class="form-label">Income Amount (KWD)</label>
                            <input type="number" step="0.01" class="form-control" id="income" name="income" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Income</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Return Capital Modal -->
    <div class="modal fade" id="returnCapitalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Capital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="returnCapitalForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="returned_amount" class="form-label">Returned Amount (KWD)</label>
                            <input type="number" step="0.01" class="form-control" id="returned_amount" name="returned_amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Record Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addIncome(investmentId) {
            document.getElementById('addIncomeForm').action = `/investments/${investmentId}/add-income`;
            new bootstrap.Modal(document.getElementById('addIncomeModal')).show();
        }

        function returnCapital(investmentId) {
            document.getElementById('returnCapitalForm').action = `/investments/${investmentId}/return-capital`;
            new bootstrap.Modal(document.getElementById('returnCapitalModal')).show();
        }
    </script>
@endsection