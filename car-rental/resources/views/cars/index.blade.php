@extends('layouts.user')

@section('title', 'Araçlar - Araç Kiralama')

@section('content')
<!-- Helper functions -->
@php
function translateFuelType($type) {
    $mapping = [
        'benzin' => 'Benzin',
        'dizel' => 'Dizel',
        'elektrik' => 'Elektrik',
        'hybrid' => 'Hibrit'
    ];
    return $mapping[$type] ?? ucfirst($type);
}

function translateTransmission($transmission) {
    $mapping = [
        'manuel' => 'Manuel',
        'otomatik' => 'Otomatik'
    ];
    return $mapping[$transmission] ?? ucfirst($transmission);
}
@endphp

<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Araç Filomuz</h1>
                <p class="lead mb-4">En kaliteli araçlarla hizmet veriyoruz. Hemen seçiminizi yapın ve yolculuğa başlayın!</p>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&q=80&w=500" 
                     alt="Araç Filosu" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Bildirimler -->
@if (session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

@if (session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<!-- Araç Arama Formu -->
<section class="py-4 bg-light">
    <div class="container">
        <form action="{{ route('cars.index') }}" method="GET" class="card border-0 shadow">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-primary fw-bold"><i class="fas fa-calendar-alt me-2"></i>Alış Tarihi</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-primary fw-bold"><i class="fas fa-calendar-check me-2"></i>İade Tarihi</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-primary fw-bold"><i class="fas fa-gas-pump me-2"></i>Yakıt Tipi</label>
                        <select name="fuel_type" class="form-select">
                            <option value="">Tümü</option>
                            <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>Benzin</option>
                            <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Dizel</option>
                            <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hibrit</option>
                            <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Elektrik</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-primary fw-bold"><i class="fas fa-cog me-2"></i>Vites</label>
                        <select name="transmission" class="form-select">
                            <option value="">Tümü</option>
                            <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manuel</option>
                            <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Otomatik</option>
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Araç Ara
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Temizle
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Filtreleme ve Sıralama -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('cars.index') }}" method="GET" class="row align-items-center">
            <!-- Mevcut filtreleri koru -->
            @if(request('fuel_type'))
                <input type="hidden" name="fuel_type" value="{{ request('fuel_type') }}">
            @endif
            @if(request('transmission'))
                <input type="hidden" name="transmission" value="{{ request('transmission') }}">
            @endif
            
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                    <input type="text" id="carSearch" class="form-control" placeholder="Marka veya model ara...">
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
                <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Fiyat (Artan)</option>
                    <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Fiyat (Azalan)</option>
                    <option value="year_new" {{ $sortBy == 'year_new' ? 'selected' : '' }}>Yıl (Yeni)</option>
                    <option value="year_old" {{ $sortBy == 'year_old' ? 'selected' : '' }}>Yıl (Eski)</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Araçlar Listesi -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 border-start border-primary border-4 ps-3">Mevcut Araçlar</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" id="gridView">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="btn btn-outline-primary" id="listView">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <!-- Grid View -->
        <div class="row g-4" id="carsGrid">
            @forelse($cars as $car)
                <div class="col-md-4 car-card">
                    <div class="card h-100 border-0 shadow-sm hover-scale transition">
                        <div class="position-relative">
                            <img src="{{ $car->image_url ?? 'https://via.placeholder.com/300x200?text=Araç+Görseli' }}" 
                                 class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}">
                            <span class="position-absolute top-0 end-0 bg-primary text-white py-1 px-2 m-2 rounded">
                                {{ number_format($car->price_per_day, 0) }} ₺/gün
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-primary">{{ $car->brand }} {{ $car->model }}</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-light text-dark"><i class="fas fa-calendar me-1"></i>{{ $car->year }}</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-gas-pump me-1"></i>{{ translateFuelType($car->fuel_type ?? 'Belirtilmemiş') }}</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-cog me-1"></i>{{ translateTransmission($car->transmission ?? 'Belirtilmemiş') }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users me-2 text-secondary"></i>
                                        <span>{{ $car->seats ?? '5' }} Kişilik</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-1">
                                        <i class="fas fa-tag me-2 text-secondary"></i>
                                        <span>{{ ucfirst($car->status ?? 'available') }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-info-circle me-2"></i>Detaylar
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info shadow-sm">
                        <i class="fas fa-info-circle me-2"></i>Aradığınız kriterlere uygun araç bulunamadı.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- List View -->
        <div class="d-none" id="carsList">
            @forelse($cars as $car)
                <div class="card border-0 shadow-sm mb-4 car-card hover-scale transition">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $car->image_url ?? 'https://via.placeholder.com/300x200?text=Araç+Görseli' }}" 
                                 class="img-fluid h-100 object-fit-cover rounded-start" alt="{{ $car->brand }} {{ $car->model }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-bold text-primary">{{ $car->brand }} {{ $car->model }}</h5>
                                        <div class="mb-3">
                                            <span class="badge bg-light text-dark me-2"><i class="fas fa-calendar me-1"></i>{{ $car->year }}</span>
                                            <span class="badge bg-light text-dark me-2"><i class="fas fa-gas-pump me-1"></i>{{ translateFuelType($car->fuel_type ?? 'Belirtilmemiş') }}</span>
                                            <span class="badge bg-light text-dark"><i class="fas fa-cog me-1"></i>{{ translateTransmission($car->transmission ?? 'Belirtilmemiş') }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-users me-2 text-secondary"></i>
                                                <span>{{ $car->seats ?? '5' }} Kişilik</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-tag me-2 text-secondary"></i>
                                                <span>{{ ucfirst($car->status ?? 'available') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="h5 mb-0 d-block text-primary fw-bold">{{ number_format($car->price_per_day, 0) }} ₺/gün</span>
                                        <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-info-circle me-2"></i>Detaylar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>Aradığınız kriterlere uygun araç bulunamadı.
                </div>
            @endforelse
        </div>
    </div>
</section>

@push('styles')
<style>
    .hover-scale {
        transition: transform 0.3s;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const carsGrid = document.getElementById('carsGrid');
        const carsList = document.getElementById('carsList');
        const carSearch = document.getElementById('carSearch');

        // View switching
        if (gridView && listView && carsGrid && carsList) {
            gridView.addEventListener('click', function() {
                carsGrid.classList.remove('d-none');
                carsList.classList.add('d-none');
                gridView.classList.add('active');
                listView.classList.remove('active');
                localStorage.setItem('carsViewPreference', 'grid');
            });

            listView.addEventListener('click', function() {
                carsGrid.classList.add('d-none');
                carsList.classList.remove('d-none');
                gridView.classList.remove('active');
                listView.classList.add('active');
                localStorage.setItem('carsViewPreference', 'list');
            });

            // Load user preference
            const viewPreference = localStorage.getItem('carsViewPreference');
            if (viewPreference === 'list') {
                listView.click();
            } else {
                gridView.click();
            }
        }

        // Search functionality
        if (carSearch) {
            carSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.car-card').forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
