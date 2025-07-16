@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Yeni Araç Ekle</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cars.index') }}">Araçlar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yeni Araç</li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" id="carForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">Marka <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="year" class="form-label">Yıl <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price_per_day" class="form-label">Günlük Fiyat (₺) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="seats" class="form-label">Koltuk Sayısı <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="seats" name="seats" value="{{ old('seats', 5) }}" min="1" max="50" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fuel_type" class="form-label">Yakıt Tipi <span class="text-danger">*</span></label>
                        <select class="form-select" id="fuel_type" name="fuel_type" required>
                            <option value="">Seçiniz</option>
                            <option value="benzin" {{ old('fuel_type') == 'benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="dizel" {{ old('fuel_type') == 'dizel' ? 'selected' : '' }}>Dizel</option>
                            <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hibrit</option>
                            <option value="elektrik" {{ old('fuel_type') == 'elektrik' ? 'selected' : '' }}>Elektrik</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="transmission" class="form-label">Şanzıman <span class="text-danger">*</span></label>
                        <select class="form-select" id="transmission" name="transmission" required>
                            <option value="">Seçiniz</option>
                            <option value="manuel" {{ old('transmission') == 'manuel' ? 'selected' : '' }}>Manuel</option>
                            <option value="otomatik" {{ old('transmission') == 'otomatik' ? 'selected' : '' }}>Otomatik</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Seçiniz</option>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Müsait</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Araç Görseli</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg">
                    <div class="form-text">PNG, JPG veya JPEG formatında, en fazla 2MB boyutunda olmalıdır.</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Geri
                    </a>
                    <button type="submit" id="submitButton" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i>ARAÇ EKLE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sabit Ekle Butonu -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <button type="button" id="floatingSubmitButton" class="btn btn-success btn-lg rounded-circle shadow">
        <i class="fas fa-plus"></i>
    </button>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('carForm');
        const submitButton = document.getElementById('submitButton');
        const floatingSubmitButton = document.getElementById('floatingSubmitButton');
        
        if (form && (submitButton || floatingSubmitButton)) {
            // Form gönderme işlevi
            const submitForm = function(e) {
                if (e) e.preventDefault();
                
                // Form validasyonu
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    alert('Lütfen tüm zorunlu alanları doldurun.');
                    return;
                }
                
                // Form geçerliyse
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> İŞLENİYOR...';
                }
                
                if (floatingSubmitButton) {
                    floatingSubmitButton.disabled = true;
                    floatingSubmitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                }
                
                // Form gönder
                form.submit();
            };
            
            // Normal butona tıklama
            if (submitButton) {
                submitButton.addEventListener('click', submitForm);
            }
            
            // Yüzen butona tıklama
            if (floatingSubmitButton) {
                floatingSubmitButton.addEventListener('click', submitForm);
            }
        }
    });
</script>
@endpush 