@extends('layouts.user')

@section('title', 'Kayıt Ol - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2 class="mb-0">Kayıt Ol</h2>
                            <p class="text-muted">Yeni bir hesap oluşturarak araç kiralama işlemlerinizi gerçekleştirebilirsiniz.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ad Soyad</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">E-posta</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-envelope text-primary"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Telefon</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-phone text-primary"></i>
                                            </span>
                                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Adres</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                            </span>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Şifre</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-lock text-primary"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Şifre (Tekrar)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-lock text-primary"></i>
                                            </span>
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" id="terms" class="form-check-input @error('terms') is-invalid @enderror" required>
                                    <label class="form-check-label" for="terms">
                                        <a href="#" class="text-primary text-decoration-none">Kullanım Koşulları</a>'nı ve
                                        <a href="#" class="text-primary text-decoration-none">Gizlilik Politikası</a>'nı kabul ediyorum
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Kayıt Ol
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Zaten hesabınız var mı? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Giriş Yap</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 