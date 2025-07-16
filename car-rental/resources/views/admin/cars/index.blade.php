@extends('layouts.admin')

@section('title', 'Araç Yönetimi')

@section('content')
<div class="container-fluid">
    <!-- Üst Banner -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Araç Yönetimi</h2>
                    <p class="mb-0 opacity-75">Tüm araçları görüntüleyin ve yönetin</p>
                </div>
                <div>
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2"></i>Yeni Araç
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Araç Kartları -->
    <div class="row g-4">
        @foreach($cars as $car)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 car-card">
                <div class="position-relative">
                    @if($car->image_url)
                        <img src="{{ asset('storage/' . $car->image_url) }}" 
                             class="card-img-top" 
                             alt="{{ $car->brand }} {{ $car->model }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-car fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="position-absolute top-0 end-0 p-2">
                        @switch($car->status)
                            @case('available')
                                <span class="badge bg-success">Müsait</span>
                                @break
                            @case('rented')
                                <span class="badge bg-warning">Kirada</span>
                                @break
                            @case('maintenance')
                                <span class="badge bg-danger">Bakımda</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $car->brand }} {{ $car->model }}</h5>
                    
                    <div class="car-features mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $car->seats }} Koltuklu
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-cog me-2"></i>
                                    {{ $car->transmission }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-gas-pump me-2"></i>
                                    {{ $car->fuel_type }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-calendar me-2"></i>
                                    {{ $car->year }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-primary">{{ number_format($car->price_per_day, 2) }} ₺</h4>
                            <small class="text-muted">Günlük</small>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i>İşlemler
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="{{ route('admin.cars.edit', $car->id) }}" class="dropdown-item">
                                        <i class="fas fa-edit me-2"></i>Düzenle
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.cars.update', $car) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="available">
                                        <button type="submit" class="dropdown-item text-success">
                                            <i class="fas fa-check me-2"></i>Müsait
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.cars.update', $car) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="maintenance">
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-tools me-2"></i>Bakıma Al
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" 
                                          onsubmit="return confirm('Bu aracı silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>Sil
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
    .car-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .car-features {
        font-size: 0.9rem;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.8em;
    }
</style>
@endpush
@endsection 