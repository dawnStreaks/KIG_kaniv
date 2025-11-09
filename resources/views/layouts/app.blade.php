<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Multi-Level Management System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            max-height: 100vh;
            background-color: #343a40;
            z-index: 1000;
            overflow-y: scroll;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 0;
            min-height: 100vh;
        }
        @media (min-width: 768px) {
            .main-content {
                margin-left: 250px;
            }
        }
        body {
            overflow-x: hidden;
        }
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pagination .page-item {
            display: inline-block;
        }
        .pagination .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            width: 38px;
            font-size: 14px;
            line-height: 1;
        }
        .pagination .page-item .page-link span {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar position-fixed d-none d-md-block" style="width: 250px;">
        <div class="p-3">
            <h5 class="text-white">Management System</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            
            @auth
                @if(auth()->user()->user_type == 'area')
                    <div class="px-3 py-2">
                        <small class="text-muted">AREA</small>
                    </div>
                    <a class="nav-link" href="{{ route('applications.index') }}">Applications</a>
                    <a class="nav-link" href="{{ route('collections.index') }}">Collections</a>
                    <a class="nav-link" href="{{ route('collections.report') }}">Collection Report</a>
                @elseif(auth()->user()->user_type == 'mekhala')
                    <div class="px-3 py-2">
                        <small class="text-muted">MEKHALA - {{ strtoupper(auth()->user()->role ?? 'N/A') }}</small>
                    </div>
                    @if(auth()->user()->canApproveApplications())
                        <a class="nav-link" href="{{ route('applications.review') }}">Review Applications</a>
                    @endif
                    @if(auth()->user()->canAddExpenses())
                        <a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a>
                    @endif
                    <a class="nav-link" href="{{ route('investments.index') }}">Investments</a>
                    
                    <div class="px-3 py-2">
                        <small class="text-muted">REPORTS</small>
                    </div>
                    <a class="nav-link" href="{{ route('reports.financial') }}">Financial Statement</a>
                    <a class="nav-link" href="{{ route('reports.collection') }}">Collection Report</a>
                    <a class="nav-link" href="{{ route('collections.report') }}">Collection Chart Report</a>
                    <a class="nav-link" href="{{ route('reports.application-payment') }}">Application Payment</a>
                @else
                    @if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'center')
                        <div class="px-3 py-2">
                            <small class="text-muted">{{ strtoupper(auth()->user()->user_type) }}</small>
                        </div>
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                        <a class="nav-link" href="{{ route('admin.areas.index') }}">Areas</a>
                        <a class="nav-link" href="{{ route('admin.mekhalas.index') }}">Mekhalas</a>
                        <a class="nav-link" href="{{ route('admin.units.index') }}">Units</a>
                        
                        <div class="px-3 py-2">
                            <small class="text-muted">COLLECTION SETTINGS</small>
                        </div>
                        <a class="nav-link" href="{{ route('admin.terms.index') }}">Manage Terms</a>
                        <a class="nav-link" href="{{ route('admin.types.index') }}">Manage Types</a>
                        
                        <div class="px-3 py-2">
                            <small class="text-muted">MAIN</small>
                        </div>
                        <a class="nav-link" href="{{ route('applications.index') }}">Applications</a>
                        <a class="nav-link" href="{{ route('collections.index') }}">Collections</a>
                        <a class="nav-link" href="{{ route('applications.review') }}">Review Applications</a>
                        <a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a>
                        <a class="nav-link" href="{{ route('investments.index') }}">Investments</a>
                        
                        <div class="px-3 py-2">
                            <small class="text-muted">REPORTS</small>
                        </div>
                        <a class="nav-link" href="{{ route('reports.financial') }}">Financial Statement</a>
                        <a class="nav-link" href="{{ route('reports.collection') }}">Collection Report</a>
                        <a class="nav-link" href="{{ route('collections.report') }}">Collection Chart Report</a>
                        <a class="nav-link" href="{{ route('reports.application-payment') }}">Application Payment</a>
                    @endif
                @endif
            @endauth
        </nav>
        
        <div class="position-absolute bottom-0 w-100 p-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation for Mobile -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Management System</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        // Set active navigation link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>