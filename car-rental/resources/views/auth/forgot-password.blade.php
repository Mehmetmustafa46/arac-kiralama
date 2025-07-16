@extends('layouts.user')

@section('title', 'Şifremi Unuttum - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-key"></i>
                            </div>
                            <h2 class="mb-0">Şifremi Unuttum</h2>
                            <p class="text-muted">E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label">E-posta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Şifre Sıfırlama Bağlantısı Gönder
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Şifrenizi hatırladınız mı? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Giriş Yap</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 