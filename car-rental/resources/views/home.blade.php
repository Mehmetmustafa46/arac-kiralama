@extends('layouts.user')

@section('title', 'Ana Sayfa - Araç Kiralama')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Hayalinizdeki Aracı Kiralayın</h1>
                    <p class="lead mb-4">Geniş araç filomuz ve uygun fiyatlarımızla sizlere en iyi hizmeti sunuyoruz.</p>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-car me-2"></i>Araçları İncele
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-white p-4 shadow-sm">
                        <h4 class="mb-4">Hızlı Araç Arama</h4>
                        <form action="{{ route('vehicles.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Alış Tarihi</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">İade Tarihi</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Araç Ara
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Neden Bizi Seçmelisiniz?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <h5 class="card-title">Geniş Araç Filosu</h5>
                            <p class="card-text">Her ihtiyaca uygun, modern ve konforlu araçlar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h5 class="card-title">Uygun Fiyatlar</h5>
                            <p class="card-text">Rekabetçi fiyatlarla kaliteli hizmet.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-3">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5 class="card-title">7/24 Destek</h5>
                            <p class="card-text">Her zaman yanınızda müşteri desteği.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Vehicles Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Popüler Araçlarımız</h2>
            <div class="row g-4">
                @foreach($popularVehicles as $vehicle)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ $vehicle->image_url }}" class="card-img-top" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $vehicle->brand }} {{ $vehicle->model }}</h5>
                                <p class="card-text">
                                    <i class="fas fa-gas-pump me-2"></i>{{ $vehicle->fuel_type }}<br>
                                    <i class="fas fa-cog me-2"></i>{{ $vehicle->transmission }}<br>
                                    <i class="fas fa-users me-2"></i>{{ $vehicle->seats }} Kişilik
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">{{ number_format($vehicle->daily_rate, 2) }} ₺/gün</span>
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-primary">
                                        <i class="fas fa-info-circle me-2"></i>Detaylar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-car me-2"></i>Tüm Araçları Gör
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Müşteri Yorumları</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Harika bir deneyimdi. Araçlar çok temiz ve bakımlıydı. Kesinlikle tekrar tercih edeceğim."</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3 text-primary"></i>
                                <div>
                                    <h6 class="mb-0">Ahmet Yılmaz</h6>
                                    <small class="text-muted">İstanbul</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Müşteri hizmetleri çok ilgiliydi. Rezervasyon süreci sorunsuz geçti."</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3 text-primary"></i>
                                <div>
                                    <h6 class="mb-0">Ayşe Demir</h6>
                                    <small class="text-muted">Ankara</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning me-2"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Fiyatlar çok uygun ve araçlar çok konforlu. Teşekkürler!"</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3 text-primary"></i>
                                <div>
                                    <h6 class="mb-0">Mehmet Kaya</h6>
                                    <small class="text-muted">İzmir</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Hemen Rezervasyon Yapın</h2>
            <p class="lead mb-4">Size en uygun aracı seçin ve hemen rezervasyon yapın.</p>
            <a href="{{ route('vehicles.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-calendar-check me-2"></i>Rezervasyon Yap
            </a>
        </div>
    </section>
@endsection 