@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Ödeme Bilgileri
                    </h5>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Rezervasyon Bilgileri</h6>
                            <p><strong>Rezervasyon No:</strong> #{{ $reservation->id }}</p>
                            <p><strong>Araç:</strong> {{ $reservation->car->brand }} {{ $reservation->car->model }}</p>
                            <p><strong>Başlangıç:</strong> {{ $reservation->start_date->format('d.m.Y') }}</p>
                            <p><strong>Bitiş:</strong> {{ $reservation->end_date->format('d.m.Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ödeme Bilgileri</h6>
                            <p><strong>Toplam Tutar:</strong> {{ number_format($reservation->total_price, 2) }} ₺</p>
                            <p><strong>Toplam Gün:</strong> {{ $reservation->start_date->diffInDays($reservation->end_date) }}</p>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-outline-primary mb-3">
                        <i class="fas fa-home me-1"></i> Ana Sayfa
                    </a>

                    <form method="POST" action="{{ route('payments.store') }}">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                        <div class="mb-4">
                            <label for="card_holder_name" class="form-label fw-bold">Kart Sahibinin Adı</label>
                            <input type="text" class="form-control @error('card_holder_name') is-invalid @enderror" 
                                id="card_holder_name" name="card_holder_name" value="{{ old('card_holder_name') }}" 
                                placeholder="Kart üzerindeki isim" required>
                            @error('card_holder_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="card_number" class="form-label fw-bold">Kart Numarası</label>
                            <input type="text" class="form-control @error('card_number') is-invalid @enderror" 
                                id="card_number" name="card_number" value="{{ old('card_number') }}" 
                                placeholder="1234 5678 9012 3456" maxlength="16" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                            @error('card_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="expiry_month" class="form-label fw-bold">Son Kullanma Ayı</label>
                                <select class="form-select @error('expiry_month') is-invalid @enderror" 
                                    id="expiry_month" name="expiry_month" required>
                                    <option value="">Ay Seçin</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('expiry_month') == $i ? 'selected' : '' }}>
                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('expiry_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="expiry_year" class="form-label fw-bold">Son Kullanma Yılı</label>
                                <select class="form-select @error('expiry_year') is-invalid @enderror" 
                                    id="expiry_year" name="expiry_year" required>
                                    <option value="">Yıl Seçin</option>
                                    @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                        <option value="{{ $i }}" {{ old('expiry_year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('expiry_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="cvv" class="form-label fw-bold">CVV</label>
                                <input type="text" class="form-control @error('cvv') is-invalid @enderror" 
                                    id="cvv" name="cvv" value="{{ old('cvv') }}" 
                                    placeholder="123" maxlength="3" required>
                                @error('cvv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Ödemeyi Tamamla
                            </button>
                            <a href="{{ route('admin.reservations.show', $reservation->id) }}">Detay</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Rezervasyon Özeti -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Rezervasyon Özeti
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-car text-primary me-2"></i>
                            <h6 class="mb-0">{{ $reservation->car->brand }} {{ $reservation->car->model }}</h6>
                        </div>
                        <p class="text-muted small mb-0">{{ $reservation->car->year }} • {{ $reservation->car->fuel_type }} • {{ $reservation->car->transmission }}</p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Alış Tarihi</span>
                        <span>{{ $reservation->start_date->format('d.m.Y') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">İade Tarihi</span>
                        <span>{{ $reservation->end_date->format('d.m.Y') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Günlük Ücret</span>
                        <span>{{ number_format($reservation->car->price_per_day, 2) }} ₺</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Kiralama Süresi</span>
                        <span>{{ $reservation->start_date->diffInDays($reservation->end_date) }} Gün</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h6 mb-0">Toplam Ücret</span>
                        <span class="h5 mb-0 text-primary">{{ number_format($reservation->total_price, 2) }} ₺</span>
                    </div>

                    <div class="alert alert-warning mb-0 mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Rezervasyonunuz onay bekliyor. Lütfen ödemeyi tamamlayın.
                    </div>

                    @switch($reservation->status)
                        @case('pending')
                            <span class="badge bg-warning">Beklemede</span>
                            @break
                        @case('approved')
                            <span class="badge bg-success">Onaylandı</span>
                            @break
                        @case('cancelled')
                            <span class="badge bg-danger">İptal Edildi</span>
                            @break
                        @case('completed')
                            <span class="badge bg-info">Tamamlandı</span>
                            @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Kart numarası için sadece sayı girişi ve 16 hane kontrolü
    document.getElementById('card_number').addEventListener('input', function(e) {
        // Sadece sayıları al ve 16 karakterle sınırla
        let value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
        this.value = value;
        
        // Input değeri değiştiyse cursor pozisyonunu koru
        if (this.value !== value) {
            this.value = value;
        }
    });

    // CVV için sadece sayı girişi
    document.getElementById('cvv').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);
    });
</script>
@endpush

@push('styles')
<style>
.card { overflow: visible !important; }
.card .dropdown-menu { z-index: 9999 !important; }
</style>
@endpush
@endsection
