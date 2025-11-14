@extends('layouts.app')

@section('title', 'Add Collection')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Bulk Unit Collections</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('collections.store') }}" id="bulkCollectionForm">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="collection_date" class="form-label">Collection Date</label>
                        <input type="date" class="form-control" id="collection_date" name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="term" class="form-label">Term</label>
                        <select class="form-control" id="term" name="term" required>
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                                <option value="{{ $term }}" {{ old('term') == $term ? 'selected' : '' }}>{{ $term }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="notes" class="form-label">Notes</label>
                        <input type="text" class="form-control" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Optional notes">
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="50"><input type="checkbox" id="selectAll"></th>
                                <th>Unit Name</th>
                                <th>Area</th>
                                <th width="150">Amount (KWD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $unit)
                            <tr>
                                <td><input type="checkbox" name="selected_units[]" value="{{ $unit->id }}" class="unit-checkbox"></td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->area->name ?? 'N/A' }}</td>
                                <td>
                                    <input type="number" step="0.001" name="amount[{{ $unit->id }}]" class="form-control form-control-sm" placeholder="0.000" min="0">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Collections</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.unit-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection