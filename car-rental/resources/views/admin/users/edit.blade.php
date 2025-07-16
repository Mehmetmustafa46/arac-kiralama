@extends('layouts.admin')

@section('title', 'Kullanıcı Düzenle')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit me-2"></i>Kullanıcı Düzenle
        </h1>
        <div>
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-eye me-2"></i>Profil Detayı
            </a>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kullanıcılara Dön
            </a>
        </div>
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
            <!-- Kullanıcı Bilgi Formu -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Kullanıcı Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Ad Soyad</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">E-posta</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Adres</label>
                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                           value="{{ old('address', $user->address) }}">
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-check form-switch mb-3">
                                    <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" 
                                           role="switch" {{ $user->is_admin ? 'checked' : '' }}>
                                    <label for="is_admin" class="form-check-label">Admin Yetkisi</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">Şifre Değiştir (isteğe bağlı)</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Yeni Şifre</label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">En az 8 karakter olmalıdır.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-light me-2">İptal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Kullanıcı Profil Kartı -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="avatar-xl rounded-circle bg-{{ $user->is_admin ? 'primary' : 'secondary' }} text-white mx-auto mb-4" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">ID: #{{ $user->id }}</p>
                    
                    <div class="d-flex justify-content-center">
                        <span class="badge bg-{{ $user->is_admin ? 'primary' : 'secondary' }} p-2">
                            {{ $user->is_admin ? 'Admin Kullanıcı' : 'Normal Kullanıcı' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Kullanıcı Bilgileri -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Hesap Özeti
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Kayıt Tarihi</span>
                            <span>{{ $user->created_at->format('d.m.Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">E-posta</span>
                            <span>{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Telefon</span>
                            <span>{{ $user->phone ?? 'Belirtilmemiş' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 