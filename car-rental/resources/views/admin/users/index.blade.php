@extends('layouts.admin')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
<div class="container-fluid">
    <!-- Üst Banner -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Kullanıcı Yönetimi</h2>
                    <p class="mb-0 opacity-75">Tüm kullanıcıları görüntüleyin ve yönetin</p>
                </div>
                <div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filtrele
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- İstatistikler -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Toplam Kullanıcı</h6>
                            <h3 class="mb-0">{{ $users->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Aktif Kullanıcılar</h6>
                            <h3 class="mb-0">{{ $users->where('status', 'active')->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Bu Ay Katılan</h6>
                            <h3 class="mb-0">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Pasif Kullanıcılar</h6>
                            <h3 class="mb-0">{{ $users->where('status', 'inactive')->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kullanıcı Listesi -->
    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i>Kullanıcı Listesi
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kullanıcı</th>
                            <th>İletişim</th>
                            <th>Kayıt Tarihi</th>
                            <th>Son Giriş</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                     alt="{{ $user->name }}" 
                                                     class="rounded-circle" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="avatar bg-light rounded-circle p-2">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->role ?? 'Kullanıcı' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="mb-1">
                                            <i class="fas fa-envelope text-primary me-1"></i>
                                            {{ $user->email }}
                                        </div>
                                        @if($user->phone)
                                            <div>
                                                <i class="fas fa-phone text-success me-1"></i>
                                                {{ $user->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        {{ $user->created_at->format('d.m.Y') }}
                                        <small class="d-block text-muted">
                                            {{ $user->created_at->format('H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    @if($user->last_login_at)
                                        <div>
                                            <i class="fas fa-clock text-info me-1"></i>
                                            {{ $user->last_login_at->format('d.m.Y') }}
                                            <small class="d-block text-muted">
                                                {{ $user->last_login_at->format('H:i') }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">Henüz giriş yapmadı</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog me-1"></i>İşlemler
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i>Görüntüle
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit me-2"></i>Düzenle
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            @if($user->status === 'active')
                                                <li>
                                                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="inactive">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-user-slash me-2"></i>Pasif Yap
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="active">
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="fas fa-user-check me-2"></i>Aktif Yap
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Filtreleme Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-filter me-2"></i>Kullanıcıları Filtrele
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Pasif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kayıt Tarihi</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="date" name="start_date" class="form-control" placeholder="Başlangıç">
                            </div>
                            <div class="col-6">
                                <input type="date" name="end_date" class="form-control" placeholder="Bitiş">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Filtrele</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stats-card .icon {
        font-size: 2.5rem;
        opacity: 0.3;
    }
    
    .table th {
        font-weight: 600;
        background: #f8f9fa;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.8em;
    }
</style>
@endpush
@endsection 