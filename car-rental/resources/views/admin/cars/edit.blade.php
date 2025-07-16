@extends('layouts.admin')

@section('title', 'Araç Düzenle')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Araç Düzenle
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Fotoğraf Yükleme -->
                    <div class="col-12">
                        <div class="image-upload-container border rounded p-3">
                            <div class="mb-3 text-center">
                                @if($car->image_url)
                                    <img id="preview" src="{{ asset('storage/' . $car->image_url) }}" alt="Araç Fotoğrafı" style="max-height: 200px;">
                                    <div id="placeholder" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; display: none;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                    </div>
                                @else
                                    <img id="preview" src="#" alt="Araç Fotoğrafı" style="max-height: 200px; display: none;">
                                    <div id="placeholder" class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Araç Fotoğrafı</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">PNG, JPG veya JPEG formatında, en fazla 2MB boyutunda olmalıdır.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Temel Bilgiler -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Marka <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" required value="{{ old('brand', $car->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" required value="{{ old('model', $car->model) }}">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Yıl <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" required value="{{ old('year', $car->year) }}">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Araç Özellikleri -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Yakıt Tipi <span class="text-danger">*</span></label>
                            <select name="fuel_type" class="form-select @error('fuel_type') is-invalid @enderror" required>
                                <option value="">Seçiniz</option>
                                <option value="Benzin" {{ old('fuel_type', $car->fuel_type) == 'Benzin' ? 'selected' : '' }}>Benzin</option>
                                <option value="Dizel" {{ old('fuel_type', $car->fuel_type) == 'Dizel' ? 'selected' : '' }}>Dizel</option>
                                <option value="LPG" {{ old('fuel_type', $car->fuel_type) == 'LPG' ? 'selected' : '' }}>LPG</option>
                                <option value="Elektrik" {{ old('fuel_type', $car->fuel_type) == 'Elektrik' ? 'selected' : '' }}>Elektrik</option>
                                <option value="Hibrit" {{ old('fuel_type', $car->fuel_type) == 'Hibrit' ? 'selected' : '' }}>Hibrit</option>
                            </select>
                            @error('fuel_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Vites <span class="text-danger">*</span></label>
                            <select name="transmission" class="form-select @error('transmission') is-invalid @enderror" required>
                                <option value="">Seçiniz</option>
                                <option value="Manuel" {{ old('transmission', $car->transmission) == 'Manuel' ? 'selected' : '' }}>Manuel</option>
                                <option value="Otomatik" {{ old('transmission', $car->transmission) == 'Otomatik' ? 'selected' : '' }}>Otomatik</option>
                                <option value="Yarı Otomatik" {{ old('transmission', $car->transmission) == 'Yarı Otomatik' ? 'selected' : '' }}>Yarı Otomatik</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Koltuk Sayısı <span class="text-danger">*</span></label>
                            <input type="number" name="seats" class="form-control @error('seats') is-invalid @enderror" required value="{{ old('seats', $car->seats) }}">
                            @error('seats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Günlük Fiyat (₺) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror" required value="{{ old('price_per_day', $car->price_per_day) }}">
                            @error('price_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Durum <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>Müsait</option>
                                <option value="rented" {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>Kirada</option>
                                <option value="maintenance" {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Açıklama -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Açıklama</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $car->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary me-2">İptal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@push('styles')
<style>
.image-upload-container {
    background-color: #f8f9fa;
}

.image-upload-container img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
}
</style>
@endpush
@endsection 