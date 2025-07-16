@extends('layouts.user')

@section('title', $car->brand . ' ' . $car->model . ' - Araç Detayları')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Araç Bilgileri -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="{{ $car->image_url ?? 'https://via.placeholder.com/800x400?text=Araç+Görseli' }}" 
                             alt="{{ $car->brand }} {{ $car->model }}" 
                             class="card-img-top">
                        <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-2 m-3 rounded-pill fw-bold">
                            {{ number_format($car->price_per_day, 0) }} ₺/gün
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h1 class="h3 fw-bold mb-3">{{ $car->brand }} {{ $car->model }}</h1>
                        
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-calendar me-1"></i> {{ $car->year }}
                            </span>
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type ?? 'Belirtilmemiş' }}
                            </span>
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-cog me-1"></i> {{ $car->transmission ?? 'Belirtilmemiş' }}
                            </span>
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-users me-1"></i> {{ $car->seats ?? 5 }} Kişilik
                            </span>
                        </div>
                        
                        @if($car->description)
                            <div class="mb-4">
                                <h5 class="fw-bold">Araç Hakkında</h5>
                                <p>{{ $car->description }}</p>
                            </div>
                        @endif
                        
                        <div class="table-responsive mb-4">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th><i class="fas fa-car-side me-2 text-primary"></i>Marka</th>
                                        <td>{{ $car->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-car me-2 text-primary"></i>Model</th>
                                        <td>{{ $car->model }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-calendar-alt me-2 text-primary"></i>Yıl</th>
                                        <td>{{ $car->year }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-gas-pump me-2 text-primary"></i>Yakıt Tipi</th>
                                        <td>{{ $car->fuel_type ?? 'Belirtilmemiş' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-cog me-2 text-primary"></i>Vites</th>
                                        <td>{{ $car->transmission ?? 'Belirtilmemiş' }}</td>
                                    </tr>
                                    <tr>
                                        <th><i class="fas fa-users me-2 text-primary"></i>Koltuk Sayısı</th>
                                        <td>{{ $car->seats ?? 5 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Yorumlar -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-4">Müşteri Yorumları</h3>
                    
                    @forelse($car->reviews as $review)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">{{ $review->user->name }}</h6>
                                <div class="mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-muted mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Bu araç için henüz yorum yapılmamış.
                        </div>
                    @endforelse
                    
                    @auth
                        <hr class="my-4">
                        <h5 class="mb-3">Yorum Yap</h5>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Puan</label>
                                <div class="rating">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating1" value="1">
                                        <label class="form-check-label" for="rating1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating2" value="2">
                                        <label class="form-check-label" for="rating2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3">
                                        <label class="form-check-label" for="rating3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4">
                                        <label class="form-check-label" for="rating4">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5" checked>
                                        <label class="form-check-label" for="rating5">5</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Yorumunuz</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Yorum Gönder
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Rezervasyon Bölümü -->
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-calendar-check me-2"></i>
                        Rezervasyon Yap
                    </h5>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Günlük Ücret</span>
                            <span class="fw-bold text-primary">{{ number_format($car->price_per_day, 2) }} ₺</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Durum</span>
                            <span class="badge bg-success">Müsait</span>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('reservations.create', $car->id) }}" class="btn btn-primary w-100 py-3 mb-3">
                            <i class="fas fa-car me-2"></i>Hemen Kirala
                        </a>
                        <div class="text-center text-muted">
                            <small>* Rezervasyon oluşturmak için tıklayın</small>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Rezervasyon yapabilmek için <a href="{{ route('login') }}" class="alert-link">giriş yapmanız</a> gerekiyor.
                        </div>
                    @endauth
                </div>
            </div>
            
            <!-- Ekstra Özellikler Bölümü -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-plus-circle me-2"></i>
                        Ekstra Hizmetler
                    </h5>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Ücretsiz iptal (24 saat öncesinde)</span>
                        </li>
                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Kasko sigortası dahil</span>
                        </li>
                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>7/24 yol yardımı</span>
                        </li>
                        <li class="list-group-item border-0 px-0 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <span>Sınırsız kilometre</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
