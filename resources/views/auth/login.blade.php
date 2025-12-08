<!DOCTYPE html>
<html>
<head>
    <title>Multi-Level Management System - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .logo-container {
            background: white;
            min-height: 100vh;
        }
        .banner-section {
            position: relative;
            margin-bottom: 2rem;
        }
        .banner-logo {
            max-width: 100%;
            height: auto;
        }
        .kaniv-logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 100%;
            height: auto;
        }
        .partner-logo {
            width: 100%;
            height: auto;
            object-fit: contain;
            margin: 10px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 200px;
            max-height: 150px;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <div class="container">
            <!-- Kaniv Logo at Top -->
            <div class="text-center py-3">
                <img src="{{ asset('logos/kaniv.png') }}" alt="Kaniv Logo" class="w-100" style="max-width: 400px;">
            </div>
            
            <!-- Header Banner -->
            <div class="banner-section text-center">
                <img src="{{ asset('logos/KIGbanner.png') }}" alt="KIG Banner" class="banner-logo">
            </div>
            
            <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
                <!-- Left Logo -->
                <div class="col-md-3 text-center">
                    <img src="{{ asset('logos/iwa_logo-01.png') }}" alt="IWA Logo" class="partner-logo">
                </div>
                
                <!-- Login Form -->
                <div class="col-md-6">
                    <div class="card login-card">
                        <div class="card-header text-center border-0 bg-transparent">
                            <h4 class="mb-0 text-primary">Login</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ url('/login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                            
                            <div class="text-center mt-3">
                                <p class="mb-0">Don't have an account? <a href="{{ url('/register') }}" class="btn btn-outline-secondary">Register</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Logo -->
                <div class="col-md-3 text-center">
                    <img src="{{ asset('logos/yi logo.png') }}" alt="YI Logo" class="partner-logo">
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>