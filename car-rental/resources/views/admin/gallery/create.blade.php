@extends('layouts.admin')

@section('title', 'Fotoğraf Ekle')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-image me-2"></i>{{ $car->brand }} {{ $car->model }} - Fotoğraf Ekle
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
    
    <!-- Özel Hata Mesajı -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Yeni Fotoğraf
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.store', $car->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Fotoğraf <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>
                            </div>
                            <div class="form-text">İzin verilen dosya türleri: JPG, JPEG, PNG. Maksimum dosya boyutu: 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}">
                            <div class="form-text">İsteğe bağlı olarak fotoğraf için başlık girebilirsiniz.</div>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="display_order" class="form-label">Gösterim Sırası</label>
                            <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" 
                                   value="{{ old('display_order', 0) }}" min="0">
                            <div class="form-text">Fotoğrafın gösterim sırasını belirler. Yüksek değerler daha önce gösterilir.</div>
                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_primary" id="is_primary" class="form-check-input @error('is_primary') is-invalid @enderror" 
                                       value="1" {{ old('is_primary') ? 'checked' : '' }}>
                                <label for="is_primary" class="form-check-label">Ana görsel olarak ayarla</label>
                                <div class="form-text">Bu seçenek işaretlenirse, bu fotoğraf aracın vitrin görseli olur.</div>
                                @error('is_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.gallery.index', $car->id) }}" class="btn btn-light me-2">İptal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Fotoğrafı Kaydet
                            </button>
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
                        <li>Yüksek kaliteli fotoğraflar kullanın</li>
                        <li>İdeal boyut: 1200x800 piksel</li>
                        <li>Araç dış ve iç fotoğrafları ekleyin</li>
                        <li>Gösterim sırası aracın galeri görünümünü etkiler</li>
                        <li>Her araç için bir ana görsel belirleyin</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 