<!DOCTYPE html>
<html>
<head>
    <title>Multi-Level Management System - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Register</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ url('/register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Level</label>
                                <select class="form-control" id="user_type" name="user_type" required>
                                    <option value="">Select Level</option>
                                    <option value="area" {{ old('user_type') == 'area' ? 'selected' : '' }}>Area Level</option>
                                    <option value="mekhala" {{ old('user_type') == 'mekhala' ? 'selected' : '' }}>Mekhala Level</option>
                                    <option value="center" {{ old('user_type') == 'center' ? 'selected' : '' }}>Center</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="area_id" class="form-label">Area</label>
                                <select class="form-control" id="area_id" name="area_id" required>
                                    <option value="">Select Area</option>
                                    @if(isset($areas) && $areas->count() > 0)
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? <a href="{{ url('/login') }}" class="btn btn-outline-secondary">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>