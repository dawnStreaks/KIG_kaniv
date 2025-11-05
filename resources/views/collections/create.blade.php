@extends('layouts.app')

@section('title', 'Add Collection')

@section('content')
    <div>
        @if(auth()->user()->user_type == 'area')
            <div class="card">
                <div class="card-header">
                    <h4>Add Collections - Area Level</h4>
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="collection_date" class="form-label">Collection Date</label>
                                <input type="date" class="form-control" id="collection_date" name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2020" max="2030" required>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"> Select All</th>
                                        <th>Unit Name</th>
                                        <th>Term</th>
                                        <th>Type</th>
                                        <th>Unit Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($units as $unit)
                                    <tr>
                                        <td><input type="checkbox" name="selected_units[]" value="{{ $unit->id }}" class="unit-checkbox"></td>
                                        <td>{{ $unit->name }}</td>
                                        <td>
                                            <select name="term[{{ $unit->id }}]" class="form-control form-control-sm">
                                                <option value="">Select Term</option>
                                                @foreach($terms as $term)
                                                    <option value="{{ $term }}">{{ $term }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="type[{{ $unit->id }}]" class="form-control form-control-sm">
                                                <option value="">Select Type</option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="unit_type[{{ $unit->id }}]" class="form-control form-control-sm" placeholder="Unit Type">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="amount[{{ $unit->id }}]" class="form-control form-control-sm" placeholder="Amount">
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
        @else
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add New Collection</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('collections.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="collection_date" class="form-label">Collection Date</label>
                                    <input type="date" class="form-control" id="collection_date" name="collection_date" value="{{ old('collection_date') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="unit_id" class="form-label">Unit</label>
                                    <select class="form-control" id="unit_id" name="unit_id" required>
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Collection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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