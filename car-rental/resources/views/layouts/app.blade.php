<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Araba Kiralama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">🚗 Araç Kiralama</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Admin Paneli Linki -->
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                Admin Paneli
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users') }}">Kullanıcılar</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reservations') }}">Rezervasyonlar</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.vehicles.index') }}">Araçlar</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservations.index') }}">Rezervasyonlarım</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profilim</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Çıkış Yap</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Giriş Yap</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Kayıt Ol</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

<footer class="text-center p-3 mt-5 bg-light">
    &copy; 2025 Araç Kiralama Sistemi
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
