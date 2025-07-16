@extends('layouts.admin')

@section('title', 'Gösterge Paneli')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gösterge Paneli</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 mb-0">{{ $stats['total_users'] ?? 0 }}</div>
                            <div class="text-white-50">Toplam Kullanıcı</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 mb-0">{{ $stats['total_reservations'] ?? 0 }}</div>
                            <div class="text-white-50">Toplam Rezervasyon</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 mb-0">{{ $stats['active_reservations'] ?? 0 }}</div>
                            <div class="text-white-50">Aktif Rezervasyon</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h3 mb-0">{{ $stats['total_cars'] ?? 0 }}</div>
                            <div class="text-white-50">Toplam Araç</div>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-car"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Rezervasyon Grafiği -->
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Rezervasyon İstatistikleri
                    <div class="btn-group float-end">
                        <button type="button" class="btn btn-sm btn-secondary active">Günlük</button>
                        <button type="button" class="btn btn-sm btn-secondary">Haftalık</button>
                        <button type="button" class="btn btn-sm btn-secondary">Aylık</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="reservationChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <!-- Araç Dağılımı -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Araç Dağılımı
                </div>
                <div class="card-body">
                    <canvas id="carTypesChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Rezervasyonlar -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Son Rezervasyonlar
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list me-1"></i>Tümünü Gör
            </a>
        </div>
        <div class="card-body">
            @if(isset($latestReservations) && count($latestReservations) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>KULLANICI</th>
                                <th>ARAÇ</th>
                                <th>BAŞLANGIÇ</th>
                                <th>BİTİŞ</th>
                                <th>TUTAR</th>
                                <th>DURUM</th>
                                <th>İŞLEMLER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReservations as $reservation)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $reservation['kullanici_avatar'] }}" 
                                                 class="rounded-circle me-2" 
                                                 width="32" height="32"
                                                 alt="{{ $reservation['kullanici'] }}">
                                            <div>{{ $reservation['kullanici'] }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $reservation['arac_foto'] }}" 
                                                 class="rounded me-2" 
                                                 width="48" height="32"
                                                 alt="{{ $reservation['arac'] }}">
                                            <div>{{ $reservation['arac'] }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $reservation['baslangic'] }}</td>
                                    <td>{{ $reservation['bitis'] }}</td>
                                    <td>{{ $reservation['tutar'] }} ₺</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation['durum_renk'] }}">
                                            {{ $reservation['durum_metin'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.reservations.show', $reservation['id']) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Görüntüle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reservations.edit', $reservation['id']) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Düzenle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>Henüz rezervasyon bulunmuyor.
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rezervasyon Grafiği
    const reservationCtx = document.getElementById('reservationChart');
    new Chart(reservationCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($weeklyStats ?? [])) !!},
            datasets: [{
                label: 'Rezervasyon Sayısı',
                data: {!! json_encode(array_values($weeklyStats ?? [])) !!},
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                backgroundColor: 'rgba(75, 192, 192, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Araç Dağılımı Grafiği
    const carTypesCtx = document.getElementById('carTypesChart');
    new Chart(carTypesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($carTypes ?? [])) !!},
            datasets: [{
                data: {!! json_encode(array_values($carTypes ?? [])) !!},
                backgroundColor: [
                    '#36a2eb',  // Mavi - Sedan
                    '#4bc0c0',  // Yeşil - SUV
                    '#ffcd56',  // Sarı - Hatchback
                    '#ff6384'   // Kırmızı - Coupe
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
@endsection 