@extends('layouts.user')

@section('title', 'Rezervasyonlarım - Araç Kiralama')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Rezervasyonlarım</h2>

        @if($reservations->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="display-4 text-muted mb-3">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h4>Henüz Rezervasyonunuz Yok</h4>
                    <p class="text-muted mb-4">Araç kiralama işlemi yapmak için araçlar sayfasını ziyaret edebilirsiniz.</p>
                    <a href="{{ route('cars.index') }}" class="btn btn-primary">
                        <i class="fas fa-car me-2"></i>Araçları İncele
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($reservations as $reservation)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $reservation->car->image_url ?? 'https://via.placeholder.com/300x200?text=Araç+Görseli' }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $reservation->car->brand }} {{ $reservation->car->model }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1">{{ $reservation->car->brand }} {{ $reservation->car->model }}</h5>
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
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock text-primary me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Alış Saati</small>
                                                        <span>{{ $reservation->pickup_time }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock text-primary me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">İade Saati</small>
                                                        <span>{{ $reservation->return_time }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted d-block">Toplam Ücret</small>
                                                <span class="h5 mb-0">{{ number_format($reservation->total_price, 2) }} ₺</span>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye me-2"></i>Detaylar
                                                </a>
                                                @if($reservation->status === 'pending')
                                                    <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')">
                                                            <i class="fas fa-times me-2"></i>İptal Et
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
@endsection 