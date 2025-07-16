@extends('layouts.admin')

@section('title', 'Kullanıcılar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Kullanıcılar
        </h1>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-2"></i>Filtrele
            </button>
        </div>
    </div>
    
    <!-- İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="info">
                    <h3>{{ $users->count() }}</h3>
                    <p>Toplam Kullanıcı</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="info">
                    <h3>{{ $users->where('is_admin', true)->count() }}</h3>
                    <p>Admin Kullanıcı</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="info">
                    <h3>{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                    <p>Son 30 Gün</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="info">
                    <h3>{{ now()->diffInDays($users->min('created_at') ?? now()) }}</h3>
                    <p>En Eski Üyelik (Gün)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kullanıcı Tablosu -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-friends me-2"></i>Kullanıcı Listesi
            </h5>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary">Tümünü Dışa Aktar</button>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Yazdır</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Kullanıcı</th>
                            <th>E-posta</th>
                            <th>Kayıt Tarihi</th>
                            <th class="text-center">Admin</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded-circle bg-{{ $user->is_admin ? 'primary' : 'secondary' }} text-white me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: #{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-muted me-2"></i>
                                        <span>{{ $user->created_at->format('d.m.Y H:i') }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input type="checkbox" name="is_admin" class="form-check-input" id="user-admin-{{ $user->id }}" 
                                                {{ $user->is_admin ? 'checked' : '' }} onchange="this.form.submit()" 
                                                role="switch" style="width: 2.5em; height: 1.25em;">
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            İşlemler
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('admin.users.show', $user) }}" class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i>Profil Detayı
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="dropdown-item">
                                                    <i class="fas fa-edit me-2"></i>Düzenle
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item">
                                                    <i class="fas fa-envelope me-2"></i>E-posta Gönder
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="#" class="dropdown-item text-danger">
                                                    <i class="fas fa-ban me-2"></i>Hesabı Dondur
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <nav aria-label="Sayfalama">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Önceki</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Sonraki</a>
                    </li>
                </ul>
            </nav>
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
                <form>
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Tipi</label>
                        <select class="form-select">
                            <option value="">Tümü</option>
                            <option value="1">Admin</option>
                            <option value="0">Normal Kullanıcı</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kayıt Tarihi</label>
                        <div class="input-group">
                            <input type="date" class="form-control" placeholder="Başlangıç">
                            <span class="input-group-text">-</span>
                            <input type="date" class="form-control" placeholder="Bitiş">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Arama</label>
                        <input type="text" class="form-control" placeholder="İsim veya E-posta">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary">Filtrele</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Admin toggle işlemi için onay modalı eklenebilir
        const adminSwitches = document.querySelectorAll('.form-check-input');
        
        adminSwitches.forEach(switchElem => {
            switchElem.addEventListener('change', function(e) {
                // Bu kısım isteğe bağlı olarak eklenebilir
                // if (!confirm('Kullanıcının admin durumunu değiştirmek istediğinize emin misiniz?')) {
                //     e.preventDefault();
                //     this.checked = !this.checked;
                // }
            });
        });
    });
</script>
@endpush 