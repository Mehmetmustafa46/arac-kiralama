@extends('layouts.admin')

@section('title', 'Kullanıcı Detayı')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user me-2"></i>Kullanıcı Detayı
        </h1>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kullanıcılara Dön
        </a>
    </div>

    <!-- Başarı Mesajı -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <!-- Kullanıcı Profil Kartı -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="avatar-xl rounded-circle bg-{{ $user->is_admin ? 'primary' : 'secondary' }} text-white mx-auto mb-4" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center mb-3">
                        <span class="badge bg-{{ $user->is_admin ? 'primary' : 'secondary' }} p-2">
                            <i class="fas fa-{{ $user->is_admin ? 'user-shield' : 'user' }} me-2"></i>
                            {{ $user->is_admin ? 'Admin Kullanıcı' : 'Normal Kullanıcı' }}
                        </span>
                    </div>
                    
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mt-2">
                        <i class="fas fa-edit me-2"></i>Düzenle
                    </a>
                </div>
            </div>
            
            <!-- Kullanıcı Detayları -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Hesap Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ID</span>
                            <span class="font-weight-bold">#{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Kayıt Tarihi</span>
                            <span>{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Son Güncelleme</span>
                            <span>{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Telefon</span>
                            <span>{{ $user->phone ?? 'Belirtilmemiş' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Adres</span>
                            <span>{{ $user->address ?? 'Belirtilmemiş' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- İstatistikler -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="info">
                            <h3>{{ $reservations->count() }}</h3>
                            <p>Toplam Rezervasyon</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info">
                            <h3>{{ $reservations->where('status', 'active')->count() }}</h3>
                            <p>Aktif Rezervasyon</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="info">
                            <h3>{{ $reservations->sum('total_price') }} ₺</h3>
                            <p>Toplam Harcama</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rezervasyon Geçmişi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Rezervasyon Geçmişi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Araç</th>
                                    <th>Tarih</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($reservations->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-calendar-times text-muted me-2"></i>
                                        Henüz rezervasyon yapılmamış
                                    </td>
                                </tr>
                                @else
                                    @foreach($reservations as $reservation)
                                    <tr>
                                        <td>#{{ $reservation->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar rounded bg-light p-2 me-3">
                                                    <i class="fas fa-car text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $reservation->car->brand }} {{ $reservation->car->model }}</div>
                                                    <small class="text-muted">{{ $reservation->car->year }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div>{{ $reservation->start_date->format('d.m.Y') }}</div>
                                                <small class="text-muted">{{ $reservation->end_date->format('d.m.Y') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $reservation->total_price }} ₺</span>
                                        </td>
                                        <td>
                                            @if($reservation->status == 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($reservation->status == 'pending')
                                                <span class="badge bg-warning">Beklemede</span>
                                            @elseif($reservation->status == 'completed')
                                                <span class="badge bg-primary">Tamamlandı</span>
                                            @elseif($reservation->status == 'cancelled')
                                                <span class="badge bg-danger">İptal</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 