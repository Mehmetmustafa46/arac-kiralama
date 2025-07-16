@extends('layouts.user')

@section('title', 'Şifre Sıfırla - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h2 class="mb-0">Şifre Sıfırla</h2>
                            <p class="text-muted">Yeni şifrenizi belirleyin.</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-4">
                                <label class="form-label">E-posta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Yeni Şifre</label>
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

                            <div class="mb-4">
                                <label class="form-label">Yeni Şifre (Tekrar)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-save me-2"></i>Şifreyi Sıfırla
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Giriş yapmak için <a href="{{ route('login') }}" class="text-primary text-decoration-none">tıklayın</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 