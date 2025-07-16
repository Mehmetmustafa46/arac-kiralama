@extends('layouts.admin')

@section('title', 'Araç Galerisi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-images me-2"></i>{{ $car->brand }} {{ $car->model }} - Galeri
        </h1>
        <div>
            <a href="{{ route('admin.gallery.create', $car->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-2"></i>Yeni Fotoğraf
            </a>
            <a href="{{ route('admin.cars.show', $car->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Araç Detayına Dön
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

    <!-- Fotoğraf listesi -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-photo-video me-2"></i>Fotoğraflar ({{ $gallery->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($gallery->count() > 0)
            <div class="row g-3">
                @foreach($gallery as $image)
                <div class="col-md-3">
                    <div class="card h-100 position-relative border {{ $image->is_primary ? 'border-primary' : '' }}">
                        @if($image->is_primary)
                        <div class="position-absolute badge bg-primary mt-2 ms-2">
                            <i class="fas fa-star me-1"></i>Ana Görsel
                        </div>
                        @endif
                        <img src="{{ Storage::url($image->path) }}" class="card-img-top" alt="{{ $image->title ?? 'Araç Fotoğrafı' }}" style="height: 160px; object-fit: cover;">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1 text-truncate">{{ $image->title ?? 'İsimsiz Fotoğraf' }}</h6>
                            <p class="card-text text-muted small mb-2">Sıra: {{ $image->display_order }}</p>
                            
                            <div class="d-flex justify-content-between mt-auto">
                                <a href="{{ route('admin.gallery.edit', [$car->id, $image->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', [$car->id, $image->id]) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-images text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5>Henüz Fotoğraf Yok</h5>
                <p class="text-muted">Bu araç için henüz bir fotoğraf eklenmemiş.</p>
                <a href="{{ route('admin.gallery.create', $car->id) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Fotoğraf Ekle
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 