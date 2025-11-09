@extends('layouts.app')

@section('title', 'Investments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Investments</h2>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('investments.create') }}" class="btn btn-primary">Add Investment</a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Income Generated</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investments as $investment)
                    <tr>
                        <td>{{ $investment->investment_date->format('Y-m-d') }}</td>
                        <td>₹{{ number_format($investment->amount, 2) }}</td>
                        <td>{{ $investment->description }}</td>
                        <td>₹{{ number_format($investment->income_generated, 2) }}</td>
                        <td class="{{ $investment->balance < 0 ? 'text-danger' : 'text-success' }}">
                            ₹{{ number_format($investment->balance, 2) }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $investment->status == 'approved' ? 'success' : ($investment->status == 'pending' ? 'warning' : 'info') }}">
                                {{ ucfirst(str_replace('_', ' ', $investment->status)) }}
                            </span>
                        </td>
                        <td>{{ $investment->creator->name ?? 'N/A' }}</td>
                        <td>
                            @if($investment->status == 'approved' && auth()->user()->isAdmin())
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#incomeModal{{ $investment->id }}">Add Income</button>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#returnModal{{ $investment->id }}">Return Capital</button>
                            @endif
                            @if($investment->status == 'pending' && auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('investments.approve', $investment) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No investments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $investments->links() }}
    </div>
</div>

@foreach($investments as $investment)
<!-- Income Modal for Investment {{ $investment->id }} -->
<div class="modal fade" id="incomeModal{{ $investment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Income - {{ $investment->description }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('investments.add-income', $investment) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Income: ₹{{ number_format($investment->income_generated, 2) }}</label>
                    </div>
                    <div class="mb-3">
                        <label for="income{{ $investment->id }}" class="form-label">Additional Income Amount</label>
                        <input type="number" class="form-control" id="income{{ $investment->id }}" name="income" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Income</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Capital Modal for Investment {{ $investment->id }} -->
<div class="modal fade" id="returnModal{{ $investment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return Capital - {{ $investment->description }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('investments.return-capital', $investment) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Balance: ₹{{ number_format($investment->balance, 2) }}</label>
                    </div>
                    <div class="mb-3">
                        <label for="returned_amount{{ $investment->id }}" class="form-label">Return Amount</label>
                        <input type="number" class="form-control" id="returned_amount{{ $investment->id }}" name="returned_amount" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Return Capital</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection