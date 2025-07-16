@extends('layouts.user')

@section('title', 'Profil Düzenle - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Profil Bilgileri</h2>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ad Soyad</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Adres</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="1" required>{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-4">Şifre Değiştir</h5>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mevcut Şifre</label>
                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Yeni Şifre</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Yeni Şifre (Tekrar)</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-4">Hesabı Sil</h5>
                        <p class="text-muted mb-4">Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>
                        
                        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-2"></i>Hesabı Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 