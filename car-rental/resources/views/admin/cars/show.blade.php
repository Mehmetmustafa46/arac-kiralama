@extends('layouts.admin')

@section('title', 'Araç Detayları')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-car me-2"></i>Araç Detayları
        </h1>
        <div>
            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Düzenle
            </a>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Araçlara Dön
            </a>
        </div>
    </div>

    <!-- Başarı Mesajı -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <!-- Araç Resmi ve Durum Bilgisi -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="{{ $car->image_url ?? asset('images/no-image.jpg') }}" 
                             alt="{{ $car->brand }} {{ $car->model }}" 
                             class="img-fluid w-100" style="object-fit: cover; max-height: 350px;">
                        
                        @switch($car->status)
                            @case('available')
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success p-2">Müsait</span>
                                </div>
                                @break
                            @case('rented')
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-warning p-2">Kirada</span>
                                </div>
                                @break
                            @case('maintenance')
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-danger p-2">Bakımda</span>
                                </div>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Araç Temel Bilgileri -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Temel Bilgiler
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ID</span>
                            <span class="font-weight-bold">#{{ $car->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Marka</span>
                            <span>{{ $car->brand }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Model</span>
                            <span>{{ $car->model }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Yıl</span>
                            <span>{{ $car->year }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Günlük Ücret</span>
                            <span class="badge bg-primary p-2">{{ number_format($car->price_per_day, 2) }} ₺</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Durum</span>
                            @switch($car->status)
                                @case('available')
                                    <span class="badge bg-success p-2">Müsait</span>
                                    @break
                                @case('rented')
                                    <span class="badge bg-warning p-2">Kirada</span>
                                    @break
                                @case('maintenance')
                                    <span class="badge bg-danger p-2">Bakımda</span>
                                    @break
                            @endswitch
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Durum Değiştirme -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sync-alt me-2"></i>Durum Değiştir
                    </h5>
                </div>
                <div class="card-body d-flex gap-2">
                    <form action="{{ route('admin.cars.update', $car) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="available">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-2"></i>Müsait
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.cars.update', $car) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="maintenance">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-tools me-2"></i>Bakıma Al
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-7">
            <!-- Araç Özellikleri -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-alt me-2"></i>Araç Özellikleri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="feature-card p-3 border rounded text-center">
                                <div class="mb-2">
                                    <i class="fas fa-gas-pump text-primary fs-3"></i>
                                </div>
                                <h6>Yakıt Tipi</h6>
                                <p class="mb-0">{{ $car->fuel_type }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-3 border rounded text-center">
                                <div class="mb-2">
                                    <i class="fas fa-cog text-primary fs-3"></i>
                                </div>
                                <h6>Vites</h6>
                                <p class="mb-0">{{ $car->transmission }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-3 border rounded text-center">
                                <div class="mb-2">
                                    <i class="fas fa-users text-primary fs-3"></i>
                                </div>
                                <h6>Koltuk</h6>
                                <p class="mb-0">{{ $car->seats }} Kişilik</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($car->description)
                    <div class="mt-4">
                        <h6 class="mb-2">Açıklama</h6>
                        <p>{{ $car->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Araba Görüntüleri -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-images me-2"></i>Galeri
                    </h5>
                    <a href="{{ route('admin.gallery.index', $car->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-photo-video me-2"></i>Galeriyi Yönet
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $galleryImages = $car->gallery()->orderBy('display_order', 'desc')->take(4)->get();
                    @endphp
                    
                    @if($galleryImages->count() > 0)
                    <div class="row g-3">
                        @foreach($galleryImages as $image)
                        <div class="col-md-3">
                            <div class="card h-100 position-relative {{ $image->is_primary ? 'border border-primary' : '' }}">
                                @if($image->is_primary)
                                <div class="position-absolute badge bg-primary mt-2 ms-2">
                                    <i class="fas fa-star me-1"></i>Ana Görsel
                                </div>
                                @endif
                                <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="{{ $image->title ?? 'Araç Fotoğrafı' }}" style="height: 160px; object-fit: cover;">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($car->gallery()->count() > 4)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.gallery.index', $car->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-images me-2"></i>Tüm Fotoğrafları Gör ({{ $car->gallery()->count() }})
                        </a>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-images text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-muted mb-3">Bu araç için henüz fotoğraf yüklenmemiş.</p>
                        <a href="{{ route('admin.gallery.create', $car->id) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Fotoğraf Ekle
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Rezervasyonlar -->
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Rezervasyonlar
                    </h5>
                </div>
                <div class="card-body">
                    @if($car->reservations && $car->reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Kullanıcı</th>
                                        <th>Tarih Aralığı</th>
                                        <th>Tutar</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($car->reservations as $reservation)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar rounded-circle bg-secondary text-white me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                        {{ substr($reservation->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        {{ $reservation->user->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $reservation->start_date->format('d.m.Y') }}</div>
                                                <small class="text-muted">{{ $reservation->end_date->format('d.m.Y') }}</small>
                                            </td>
                                            <td>{{ number_format($reservation->total_price, 2) }} ₺</td>
                                            <td>
                                                @switch($reservation->status)
                                                    @case('active')
                                                        <span class="badge bg-success">Aktif</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">Beklemede</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-info">Tamamlandı</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">İptal</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fs-1 text-muted mb-3"></i>
                            <p class="mb-0">Bu araca ait aktif rezervasyon bulunamadı.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 