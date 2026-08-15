@extends('layouts.app')

@section('title', 'Historical Applications')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Historical Applications</h2>
                <small class="text-muted">{{ number_format($total) }} total records — used for duplicate checking</small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.historical-applications.template') }}" class="btn btn-outline-secondary">
                    Download Template
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import Excel / CSV
                </button>
                <form method="POST" action="{{ route('admin.historical-applications.destroy-all') }}"
                      onsubmit="return confirm('Clear ALL {{ number_format($total) }} historical records? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Clear All</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.historical-applications.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Import Historical Applications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted small">
                                Upload an Excel (.xlsx, .xls) or CSV file. The first row must be headers.
                                Required columns: <strong>civil_id</strong> or <strong>passport_no</strong> or <strong>mobile_number</strong>.
                                Other columns: name, category, application_type, area, unit, status, approved_amount, applied_date, notes.
                            </p>
                            <div class="mb-3">
                                <label class="form-label">File</label>
                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <form method="GET" id="filterForm">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Passport No</th>
                                <th>Civil ID</th>
                                <th>Mobile</th>
                                <th>Category</th>
                                <th>Application Type</th>
                                <th>Area</th>
                                <th>Unit</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Applied Date</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th><input type="text" class="form-control form-control-sm" name="name" placeholder="Filter" value="{{ request('name') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="passport" placeholder="Filter" value="{{ request('passport') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="civil_id" placeholder="Filter" value="{{ request('civil_id') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="mobile" placeholder="Filter" value="{{ request('mobile') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="category" placeholder="Filter" value="{{ request('category') }}"></th>
                                <th><input type="text" class="form-control form-control-sm" name="application_type" placeholder="Filter" value="{{ request('application_type') }}"></th>
                                <th></th>
                                <th></th>
                                <th><input type="text" class="form-control form-control-sm" name="status" placeholder="Filter" value="{{ request('status') }}"></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->passport_no ?? '-' }}</td>
                                    <td>{{ $record->civil_id ?? '-' }}</td>
                                    <td>{{ $record->mobile_number ?? '-' }}</td>
                                    <td>{{ $record->category ?? '-' }}</td>
                                    <td>{{ $record->application_type ?? '-' }}</td>
                                    <td>{{ $record->area_name ?? '-' }}</td>
                                    <td>{{ $record->unit_name ?? '-' }}</td>
                                    <td>{{ $record->status ?? '-' }}</td>
                                    <td>{{ $record->approved_amount ? number_format($record->approved_amount, 3) : '-' }}</td>
                                    <td>{{ $record->applied_date ? $record->applied_date->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-muted py-4">No historical records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>

        <div class="mt-3">
            {{ $records->links() }}
        </div>
    </div>
@endsection
