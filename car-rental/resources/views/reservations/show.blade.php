@extends('layouts.user')

@section('title', 'Rezervasyon Detayı - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Vehicle Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $reservation->car->image_url }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $reservation->car->brand }} {{ $reservation->car->model }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h4 class="card-title mb-1">{{ $reservation->car->brand }} {{ $reservation->car->model }}</h4>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            {{ $reservation->start_date->format('d.m.Y') }} - {{ $reservation->end_date->format('d.m.Y') }}
                                        </p>
                                    </div>
                                    <span class="badge bg-{{ $reservation->status_color }}">
                                        {{ $reservation->status_text }}
                                    </span>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Alış Saati</small>
                                                <span>{{ $reservation->pickup_time }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">İade Saati</small>
                                                <span>{{ $reservation->return_time }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-gas-pump text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Yakıt Tipi</small>
                                                <span>{{ $reservation->car->fuel_type }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cog text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Vites</small>
                                                <span>{{ $reservation->car->transmission }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservation Details -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Rezervasyon Detayları</h5>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-user text-primary me-3 fa-2x"></i>
                                    <div>
                                        <h6 class="mb-0">Müşteri Bilgileri</h6>
                                        <p class="mb-0">{{ $reservation->user->name }}</p>
                                        <p class="mb-0">{{ $reservation->user->email }}</p>
                                        <p class="mb-0">{{ $reservation->user->phone }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-calendar-check text-primary me-3 fa-2x"></i>
                                    <div>
                                        <h6 class="mb-0">Rezervasyon Tarihi</h6>
                                        <p class="mb-0">{{ $reservation->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3 fa-2x"></i>
                                    <div>
                                        <h6 class="mb-0">Alış Lokasyonu</h6>
                                        <p class="mb-0">{{ $reservation->pickup_location }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3 fa-2x"></i>
                                    <div>
                                        <h6 class="mb-0">İade Lokasyonu</h6>
                                        <p class="mb-0">{{ $reservation->return_location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ödeme Bilgileri</h5>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Günlük Ücret</span>
                            <span>{{ number_format($reservation->car->daily_rate, 2) }} ₺</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Kiralama Süresi</span>
                            <span>{{ $reservation->duration }} Gün</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h6 mb-0">Toplam Ücret</span>
                            <span class="h5 mb-0 text-primary">{{ number_format($reservation->total_amount, 2) }} ₺</span>
                        </div>

                        @if($reservation->status === 'pending')
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Rezervasyonunuz onay bekliyor. Lütfen ödemeyi tamamlayın.
                            </div>

                            <form action="{{ route('reservations.pay', $reservation->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-credit-card me-2"></i>Ödemeyi Tamamla
                                </button>
                            </form>

                            <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')">
                                    <i class="fas fa-times me-2"></i>Rezervasyonu İptal Et
                                </button>
                            </form>
                        @elseif($reservation->status === 'confirmed')
                            <div class="alert alert-success mb-3">
                                <i class="fas fa-check-circle me-2"></i>
                                Rezervasyonunuz onaylandı.
                            </div>
                        @elseif($reservation->status === 'cancelled')
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-times-circle me-2"></i>
                                Rezervasyonunuz iptal edildi.
                            </div>
                        @elseif($reservation->status === 'completed')
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-check-circle me-2"></i>
                                Rezervasyonunuz tamamlandı.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 