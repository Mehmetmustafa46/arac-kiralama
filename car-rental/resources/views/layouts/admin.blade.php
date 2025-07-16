<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel') . ' - Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f1c40f;
            --danger-color: #e74c3c;
        }
        
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Figtree', sans-serif;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: var(--secondary-color);
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-logo {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo img {
            height: 40px;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu {
            padding: 1.5rem 0;
        }
        
        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin: 0.25rem 0;
        }
        
        .sidebar-menu .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu .nav-link.active {
            color: #fff;
            background: rgba(52, 152, 219, 0.1);
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu .nav-link i {
            width: 24px;
            margin-right: 12px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Main Content Styles */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        /* Top Navbar Styles */
        .admin-navbar {
            height: 70px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            margin-bottom: 2rem;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .admin-navbar .navbar-brand {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .admin-navbar .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-navbar .user-menu .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .admin-navbar .user-menu .dropdown-toggle img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Card Styles */
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        
        .card:hover {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem;
        }
        
        /* Button Styles */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
            transform: translateY(-1px);
        }
        
        /* Table Styles */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table-hover tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* Badge Styles */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.8em;
            border-radius: 6px;
        }
        
        /* Stats Card */
        .stats-card {
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stats-card .icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }
        
        .stats-card .info h3 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
        }
        
        .stats-card .info p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="admin-sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                <img src="{{ asset('images/logo-white.png') }}" alt="Logo">
            </a>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i> Ana Sayfa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.cars.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                        <i class="fas fa-car"></i>
                        <span>Araçlar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reservations') }}" 
                       class="nav-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Rezervasyonlar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" 
                       class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Kullanıcılar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}" 
                       class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Ayarlar</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Navbar -->
        <nav class="admin-navbar">
            <button class="btn sidebar-toggle d-md-none">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="user-menu">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Çıkış Yap</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.admin-sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.admin-sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 