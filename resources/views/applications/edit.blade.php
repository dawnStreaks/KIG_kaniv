@extends('layouts.app')

@section('title', 'Edit Application - Management System')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Application</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('applications.update', $application) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="front_page_photo" class="form-label">Front Page Photo</label>
                                <input type="file" class="form-control" id="front_page_photo" name="front_page_photo" accept="image/*">
                                @if($application->front_page_photo)
                                    <small class="text-muted">Current photo: {{ basename($application->front_page_photo) }}</small>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $application->name) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="passport_no" class="form-label">Passport No</label>
                                <input type="text" class="form-control" id="passport_no" name="passport_no" value="{{ old('passport_no', $application->passport_no) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="civil_id" class="form-label">Civil ID</label>
                                <input type="text" class="form-control" id="civil_id" name="civil_id" value="{{ old('civil_id', $application->civil_id) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number', $application->mobile_number) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="medical_support" {{ old('category', $application->category) == 'medical_support' ? 'selected' : '' }}>Medical Support</option>
                                    <option value="financial_support" {{ old('category', $application->category) == 'financial_support' ? 'selected' : '' }}>Financial Support</option>
                                    <option value="iqama_visa_residency" {{ old('category', $application->category) == 'iqama_visa_residency' ? 'selected' : '' }}>Iqama/Visa/Residency</option>
                                    <option value="ticket" {{ old('category', $application->category) == 'ticket' ? 'selected' : '' }}>Ticket</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="application_type_id" class="form-label">Application Type</label>
                                <select class="form-control" id="application_type_id" name="application_type_id">
                                    <option value="">Select Application Type</option>
                                    @foreach($applicationTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('application_type_id', $application->application_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="unit_id" class="form-label">Unit</label>
                                <select class="form-control" id="unit_id" name="unit_id" required>
                                    <option value="">Select Unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" data-area-id="{{ $unit->area_id }}" {{ old('unit_id', $application->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="area_id" class="form-label">Area</label>
                                <select class="form-control" id="area_id" name="area_id" readonly>
                                    <option value="">Select Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ old('area_id', $application->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $application->description) }}</textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('applications.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateField(field, value, inputElement) {
            if (!value) {
                clearValidation(inputElement);
                return;
            }
            
            fetch('{{ route('applications.validate-field') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    field: field,
                    value: value,
                    id: {{ $application->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    showError(inputElement, `This ${field.replace('_', ' ')} already exists`);
                } else {
                    showSuccess(inputElement);
                }
            });
        }
        
        function showError(inputElement, message) {
            inputElement.classList.add('is-invalid');
            inputElement.classList.remove('is-valid');
            
            let feedback = inputElement.parentNode.querySelector('.invalid-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                inputElement.parentNode.appendChild(feedback);
            }
            feedback.textContent = message;
        }
        
        function showSuccess(inputElement) {
            inputElement.classList.add('is-valid');
            inputElement.classList.remove('is-invalid');
            
            const feedback = inputElement.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        }
        
        function clearValidation(inputElement) {
            inputElement.classList.remove('is-valid', 'is-invalid');
            const feedback = inputElement.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const civilIdInput = document.getElementById('civil_id');
            const passportInput = document.getElementById('passport_no');
            const unitSelect = document.getElementById('unit_id');
            const areaSelect = document.getElementById('area_id');
            
            civilIdInput.addEventListener('blur', function() {
                validateField('civil_id', this.value, this);
            });
            
            passportInput.addEventListener('blur', function() {
                validateField('passport_no', this.value, this);
            });
            
            unitSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const areaId = selectedOption.getAttribute('data-area-id');
                
                if (areaId) {
                    areaSelect.value = areaId;
                } else {
                    areaSelect.value = '';
                }
            });
        });
    </script>
@endsection