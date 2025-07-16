@extends('layouts.admin')

@section('title', 'Araç Ekle')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Araç Ekle</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.cars.index') }}">Araçlar</a></li>
        <li class="breadcrumb-item active">Ekle</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-car me-1"></i>
            Yeni Araç Ekle
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cars.store') }}" method="POST">
                @csrf
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brand" class="form-label">Marka <span class="text-danger">*</span></label>
                            <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required class="form-control @error('brand') is-invalid @enderror">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" id="model" name="model" value="{{ old('model') }}" required class="form-control @error('model') is-invalid @enderror">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year" class="form-label">Yıl <span class="text-danger">*</span></label>
                            <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required class="form-control @error('year') is-invalid @enderror">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price_per_day" class="form-label">Günlük Fiyat (₺) <span class="text-danger">*</span></label>
                            <input type="number" id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" min="0" step="0.01" required class="form-control @error('price_per_day') is-invalid @enderror">
                            @error('price_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seats" class="form-label">Koltuk Sayısı <span class="text-danger">*</span></label>
                            <input type="number" id="seats" name="seats" value="{{ old('seats', 5) }}" min="1" max="50" required class="form-control @error('seats') is-invalid @enderror">
                            @error('seats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fuel_type" class="form-label">Yakıt Tipi <span class="text-danger">*</span></label>
                            <select id="fuel_type" name="fuel_type" required class="form-select @error('fuel_type') is-invalid @enderror">
                                <option value="benzin" {{ old('fuel_type') == 'benzin' ? 'selected' : '' }}>Benzin</option>
                                <option value="dizel" {{ old('fuel_type') == 'dizel' ? 'selected' : '' }}>Dizel</option>
                                <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hibrit</option>
                                <option value="elektrik" {{ old('fuel_type') == 'elektrik' ? 'selected' : '' }}>Elektrik</option>
                            </select>
                            @error('fuel_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="transmission" class="form-label">Şanzıman <span class="text-danger">*</span></label>
                            <select id="transmission" name="transmission" required class="form-select @error('transmission') is-invalid @enderror">
                                <option value="manuel" {{ old('transmission') == 'manuel' ? 'selected' : '' }}>Manuel</option>
                                <option value="otomatik" {{ old('transmission') == 'otomatik' ? 'selected' : '' }}>Otomatik</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                            <select id="status" name="status" required class="form-select @error('status') is-invalid @enderror">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Müsait</option>
                                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type" class="form-label">Araç Tipi <span class="text-danger">*</span></label>
                            <select id="type" name="type" required class="form-select @error('type') is-invalid @enderror">
                                @foreach(App\Models\Car::getTipSecenekleri() as $value => $label)
                                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="image_url" class="form-label">Araç Görseli (URL) <span class="text-danger">*</span></label>
                            <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" required 
                                   class="form-control @error('image_url') is-invalid @enderror"
                                   placeholder="https://ornek.com/araba-foto.jpg">
                            <div class="form-text text-muted">Araç fotoğrafı için bir internet adresi (URL) girin. Örnek: https://i.imgur.com/YUvn5mJ.jpg</div>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Geri
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>ARAÇ EKLE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 