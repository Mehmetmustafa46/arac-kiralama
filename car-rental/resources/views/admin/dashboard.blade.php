<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Rapor Yazdır
            </button>
            <button class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i>Excel'e Aktar
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
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
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="info">
                    <h3>{{ $reservations->count() }}</h3>
                    <p>Toplam Rezervasyon</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
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
                    <i class="fas fa-car"></i>
                </div>
                <div class="info">
                    <h3>{{ $cars->count() }}</h3>
                    <p>Toplam Araç</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Rezervasyon İstatistikleri</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Günlük</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Haftalık</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Aylık</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="reservationsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Araç Dağılımı</h5>
                </div>
                <div class="card-body">
                    <canvas id="carsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Son Rezervasyonlar</h5>
            <a href="{{ route('admin.reservations') }}" class="btn btn-primary btn-sm">
                Tümünü Gör
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kullanıcı</th>
                            <th>Araç</th>
                            <th>Başlangıç</th>
                            <th>Bitiş</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations->take(5) as $reservation)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $reservation->user->profile_photo_url }}" 
                                         alt="{{ $reservation->user->name }}" 
                                         class="rounded-circle me-2"
                                         width="32" height="32">
                                    {{ $reservation->user->name }}
                                </div>
                            </td>
                            <td>{{ $reservation->car->brand }} {{ $reservation->car->model }}</td>
                            <td>{{ $reservation->start_date->format('d.m.Y') }}</td>
                            <td>{{ $reservation->end_date->format('d.m.Y') }}</td>
                            <td>{{ number_format($reservation->total_price, 2) }} ₺</td>
                            <td>
                                <span class="badge bg-{{ $reservation->status === 'active' ? 'success' : 
                                    ($reservation->status === 'completed' ? 'info' : 'danger') }}">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.reservations.edit', $reservation) }}" 
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Rezervasyon İstatistikleri Grafiği
const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
new Chart(reservationsCtx, {
    type: 'line',
    data: {
        labels: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
        datasets: [{
            label: 'Rezervasyonlar',
            data: [12, 19, 15, 17, 22, 24, 21],
            borderColor: '#3498db',
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(52, 152, 219, 0.1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Araç Dağılımı Grafiği
const carsCtx = document.getElementById('carsChart').getContext('2d');
new Chart(carsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Sedan', 'SUV', 'Hatchback', 'Coupe'],
        datasets: [{
            data: [30, 25, 20, 15],
            backgroundColor: [
                '#3498db',
                '#2ecc71',
                '#f1c40f',
                '#e74c3c'
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

// Excel'e Aktarma Fonksiyonu
function exportToExcel() {
    // Excel export işlemleri burada yapılacak
    alert('Excel export özelliği yakında eklenecek!');
}
</script>
@endpush
@endsection
