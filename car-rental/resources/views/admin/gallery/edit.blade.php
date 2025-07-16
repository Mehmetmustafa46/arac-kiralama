@extends('layouts.admin')

@section('title', 'Fotoğraf Düzenle')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-image me-2"></i>{{ $car->brand }} {{ $car->model }} - Fotoğraf Düzenle
        </h1>
        <a href="{{ route('admin.gallery.index', $car->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Galeriye Dön
        </a>
    </div>

    <!-- Hata Mesajları -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>Lütfen formdaki hataları düzeltin:
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Fotoğraf Bilgilerini Düzenle
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.update', ['carId' => $car->id, 'id' => $image->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label">Mevcut Fotoğraf</label>
                            <div class="mb-3">
                                <img src="{{ Storage::url($image->path) }}" 
                                     alt="Gallery image" 
                                     class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            
                            <label for="image" class="form-label">Yeni Fotoğraf</label>
                            <div class="input-group">
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            </div>
                            <div class="form-text">Yeni fotoğraf yüklemek isterseniz seçin. Değiştirmek istemiyorsanız boş bırakın.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $image->title) }}">
                            <div class="form-text">İsteğe bağlı olarak fotoğraf için başlık girebilirsiniz.</div>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="display_order" class="form-label">Gösterim Sırası</label>
                            <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" 
                                   value="{{ old('display_order', $image->display_order) }}" min="0">
                            <div class="form-text">Fotoğrafın gösterim sırasını belirler. Yüksek değerler daha önce gösterilir.</div>
                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_primary" id="is_primary" class="form-check-input @error('is_primary') is-invalid @enderror" 
                                       value="1" {{ old('is_primary', $image->is_primary) ? 'checked' : '' }}>
                                <label for="is_primary" class="form-check-label">Ana görsel olarak ayarla</label>
                                <div class="form-text">Bu seçenek işaretlenirse, bu fotoğraf aracın vitrin görseli olur.</div>
                                @error('is_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <form action="{{ route('admin.gallery.destroy', ['carId' => $car->id, 'id' => $image->id]) }}" method="POST" onsubmit="return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Fotoğrafı Sil
                                </button>
                            </form>
                            
                            <div>
                                <a href="{{ route('admin.gallery.index', $car->id) }}" class="btn btn-light me-2">İptal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Araç Bilgisi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="avatar bg-light rounded p-2">
                                <i class="fas fa-car text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $car->brand }} {{ $car->model }}</h6>
                            <small class="text-muted">{{ $car->year }}</small>
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ID</span>
                            <span class="font-weight-bold">#{{ $car->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Galeri</span>
                            <span>{{ $car->gallery->count() }} Fotoğraf</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Fotoğraf ID</span>
                            <span>#{{ $image->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Yüklenme Tarihi</span>
                            <span>{{ $image->created_at->format('d.m.Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>Yardım
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0"><strong>İpuçları:</strong></p>
                    <ul class="mb-0">
                        <li>Mevcut fotoğrafı değiştirmek için yeni fotoğraf yükleyin</li>
                        <li>Ana görsel değişirse diğer fotoğraflar otomatik olarak güncellenir</li>
                        <li>Silinen fotoğraflar geri alınamaz</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 