@extends('layouts.admin')

@section('title', 'Rezervasyon Yönetimi')

@section('content')
<div class="container-fluid">
    <!-- Üst Banner -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Rezervasyon Yönetimi</h2>
                    <p class="mb-0 opacity-75">Tüm rezervasyonları görüntüleyin ve yönetin</p>
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
                            <h6 class="text-uppercase mb-1">Toplam Rezervasyon</h6>
                            <h3 class="mb-0">{{ $reservations->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
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
                            <h6 class="text-uppercase mb-1">Onaylı</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'approved')->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
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
                            <h6 class="text-uppercase mb-1">Bekleyen</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
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
                            <h6 class="text-uppercase mb-1">İptal Edilen</h6>
                            <h3 class="mb-0">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rezervasyon Listesi -->
    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Rezervasyon Listesi
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Müşteri</th>
                            <th>Araç</th>
                            <th>Tarih Aralığı</th>
                            <th>Toplam Ücret</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>#{{ $reservation->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="avatar bg-light rounded-circle p-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $reservation->user->name }}</h6>
                                            <small class="text-muted">{{ $reservation->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($reservation->vehicle->image_url)
                                            <div class="me-3">
                                                <img src="{{ asset('storage/' . $reservation->vehicle->image_url) }}" 
                                                     alt="{{ $reservation->vehicle->brand }}" 
                                                     class="rounded" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="me-3">
                                                <div class="avatar bg-light rounded p-2">
                                                    <i class="fas fa-car text-primary"></i>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</h6>
                                            <small class="text-muted">{{ $reservation->vehicle->year }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="mb-1">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                                            {{ $reservation->start_date->format('d.m.Y') }}
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar-check text-success me-1"></i>
                                            {{ $reservation->end_date->format('d.m.Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ number_format($reservation->total_price, 2) }} ₺</h6>
                                    <small class="text-muted">{{ $reservation->start_date->diffInDays($reservation->end_date) }} Gün</small>
                                </td>
                                <td>
                                    @switch($reservation->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Beklemede</span>
                                            @break
                                        @case('approved')
                                        @case('confirmed')
                                            <span class="badge bg-success">Onaylandı</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">İptal Edildi</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-info">Tamamlandı</span>
                                            @break
                                        @case('rented')
                                            <span class="badge bg-primary">Kirada</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Bilinmiyor</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog me-1"></i>İşlemler
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i>Görüntüle
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit me-2"></i>Düzenle
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="fas fa-check me-2"></i>Onayla
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-times me-2"></i>İptal Et
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item text-info">
                                                        <i class="fas fa-check-double me-2"></i>Tamamlandı
                                                    </button>
                                                </form>
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
    </div>
</div>

<!-- Filtreleme Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-filter me-2"></i>Rezervasyonları Filtrele
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.reservations') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="pending">Beklemede</option>
                            <option value="approved">Onaylandı</option>
                            <option value="cancelled">İptal Edildi</option>
                            <option value="completed">Tamamlandı</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarih Aralığı</label>
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