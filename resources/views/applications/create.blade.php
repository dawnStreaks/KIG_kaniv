@extends('layouts.app')

@section('title', 'New Application - Management System')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>New Application</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="front_page_photo" class="form-label">Front Page Photo</label>
                                <input type="file" class="form-control" id="front_page_photo" name="front_page_photo" accept="image/*" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="passport_no" class="form-label">Passport No</label>
                                <input type="text" class="form-control" id="passport_no" name="passport_no" value="{{ old('passport_no') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="civil_id" class="form-label">Civil ID</label>
                                <input type="text" class="form-control" id="civil_id" name="civil_id" value="{{ old('civil_id') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>Health</option>
                                    <option value="finance" {{ old('category') == 'finance' ? 'selected' : '' }}>Finance</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('applications.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection