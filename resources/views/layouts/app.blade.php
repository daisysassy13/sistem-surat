<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Surat') }} - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-blue: #2c3e50;
            --secondary-blue: #34495e;
            --light-blue: #ecf0f1;
            --accent-blue: #3498db;
            --hover-blue: #2980b9;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            font-size: 1.3rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-item {
            margin: 0.3rem 0.8rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background-color: var(--accent-blue);
            color: white;
            font-weight: 500;
        }

        .sidebar-link i {
            font-size: 1.2rem;
            margin-right: 0.8rem;
            width: 25px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Navbar */
        .top-navbar {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .content-wrapper {
            padding: 0 2rem 2rem 2rem;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--accent-blue);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        /* Table */
        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
        }

        .table thead th {
            background-color: var(--primary-blue);
            color: white;
            font-weight: 500;
            border: none;
            padding: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--light-blue);
        }

        /* Badges */
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        /* User Dropdown */
        .user-dropdown {
            background-color: var(--light-blue);
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        /* Form */
        .form-label {
            font-weight: 500;
            color: var(--secondary-blue);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        }
    </style>
</head>
<body>
    @auth
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-envelope-check"></i> Sistem Surat
        </div>
        <div class="sidebar-menu">
            <div class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('surat-masuk.index') }}" class="sidebar-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
                    <i class="bi bi-inbox-fill"></i>
                    <span>Surat Masuk</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('surat-keluar.index') }}" class="sidebar-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
                    <i class="bi bi-send-fill"></i>
                    <span>Surat Keluar</span>
                </a>
            </div>
            <div class="sidebar-item">
                <a href="{{ route('arsip.index') }}" class="sidebar-link {{ request()->routeIs('arsip.*') ? 'active' : '' }}">
                    <i class="bi bi-archive-fill"></i>
                    <span>Arsip</span>
                </a>
            </div>
            <div class="sidebar-item">
            <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>
        </div>
        @if(auth()->user()->role == 'admin')
        <div class="sidebar-item">
            <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Kelola User</span>
            </a>
        </div>
        @endif
        @if(auth()->user()->role == 'admin')
        <div class="sidebar-item">
            <a href="{{ route('activity-logs.index') }}" class="sidebar-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Activity Log</span>
            </a>
        </div>
        @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Selamat Datang, {{ Auth::user()->name }}</h5>
                    <small class="text-muted">{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Operator' }}</small>
                </div>
                <div class="dropdown">
                    <button class="btn user-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
    @else
    @yield('content')
    @endauth

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                pageLength: 10,
                order: [[0, 'desc']]
            });
        });
    </script>

    @stack('scripts')
</body>
</html>