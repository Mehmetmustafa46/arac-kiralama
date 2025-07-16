@extends('layouts.admin')

@section('title', 'Rezervasyonlar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-check me-2"></i>Rezervasyonlar
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
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="info">
                    <h3>{{ $reservations->count() }}</h3>
                    <p>Toplam Rezervasyon</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="info">
                    <h3>{{ $reservations->where('status', 'active')->count() }}</h3>
                    <p>Aktif Rezervasyon</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="info">
                    <h3>{{ $reservations->where('status', 'completed')->count() }}</h3>
                    <p>Tamamlanan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="info">
                    <h3>{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                    <p>İptal Edilen</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rezervasyon Tablosu -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>Rezervasyon Listesi
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
                            <th>Araç</th>
                            <th>Başlangıç</th>
                            <th>Bitiş</th>
                            <th>Toplam</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded-circle bg-primary text-white me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                            {{ substr($reservation->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $reservation->user->name }}</div>
                                            <small class="text-muted">ID: #{{ $reservation->user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $reservation->car->brand }} {{ $reservation->car->model }}</div>
                                    <small class="text-muted">{{ $reservation->car->year }}</small>
                                </td>
                                <td>{{ $reservation->start_date->format('d.m.Y') }}</td>
                                <td>{{ $reservation->end_date->format('d.m.Y') }}</td>
                                <td>
                                    <span class="fw-bold">{{ number_format($reservation->total_price, 2) }} ₺</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $reservation->status === 'active' ? 'success' : 
                                        ($reservation->status === 'completed' ? 'info' : 'danger') }}">
                                        {{ $reservation->status === 'active' ? 'Aktif' : 
                                           ($reservation->status === 'completed' ? 'Tamamlandı' : 'İptal Edildi') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            İşlemler
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i>Detay
                                                </a>
                                            </li>
                                            @if($reservation->status === 'active')
                                                <li>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fas fa-check me-2"></i>Tamamla
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fas fa-edit me-2"></i>Düzenle
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="#" class="dropdown-item text-danger">
                                                        <i class="fas fa-times me-2"></i>İptal Et
                                                    </a>
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
                    <i class="fas fa-filter me-2"></i>Rezervasyonları Filtrele
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select class="form-select">
                            <option value="">Tümü</option>
                            <option value="active">Aktif</option>
                            <option value="completed">Tamamlandı</option>
                            <option value="cancelled">İptal Edildi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarih Aralığı</label>
                        <div class="input-group">
                            <input type="date" class="form-control" placeholder="Başlangıç">
                            <span class="input-group-text">-</span>
                            <input type="date" class="form-control" placeholder="Bitiş">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı</label>
                        <input type="text" class="form-control" placeholder="Kullanıcı adı">
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
        // Burada ihtiyaç duyulan JavaScript kodları yer alabilir
    });
</script>
@endpush 