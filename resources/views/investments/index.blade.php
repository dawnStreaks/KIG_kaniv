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
                        <td>
                            <span class="badge bg-{{ $investment->status == 'approved' ? 'success' : ($investment->status == 'pending' ? 'warning' : 'info') }}">
                                {{ ucfirst(str_replace('_', ' ', $investment->status)) }}
                            </span>
                        </td>
                        <td>{{ $investment->creator->name ?? 'N/A' }}</td>
                        <td>
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
                        <td colspan="7" class="text-center">No investments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $investments->links() }}
    </div>
</div>
@endsection