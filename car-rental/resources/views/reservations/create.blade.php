@extends('layouts.user')

@section('title', 'Rezervasyon Oluştur - Araç Kiralama')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 order-lg-1 order-2">
            <!-- Rezervasyon Formu -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Rezervasyon Bilgileri</h2>
                    
                    @include('components.messages')
                    
                    <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-1 text-primary"></i> Başlangıç Tarihi
                                </label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ old('start_date', date('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Bitiş Tarihi
                                </label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_location" class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i> Teslim Alma Yeri
                                </label>
                                <select class="form-select" id="pickup_location" name="pickup_location" required>
                                    <option value="">Teslim alma yerini seçin</option>
                                    <option value="İstanbul Havalimanı">İstanbul Havalimanı</option>
                                    <option value="Sabiha Gökçen Havalimanı">Sabiha Gökçen Havalimanı</option>
                                    <option value="İstanbul Taksim">İstanbul Taksim</option>
                                    <option value="İstanbul Kadıköy">İstanbul Kadıköy</option>
                                    <option value="Ankara Esenboğa Havalimanı">Ankara Esenboğa Havalimanı</option>
                                    <option value="İzmir Adnan Menderes Havalimanı">İzmir Adnan Menderes Havalimanı</option>
                                    <option value="Antalya Havalimanı">Antalya Havalimanı</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_location" class="form-label fw-bold">
                                    <i class="fas fa-map-marker me-1 text-primary"></i> Teslim Etme Yeri
                                </label>
                                <select class="form-select" id="return_location" name="return_location" required>
                                    <option value="">Teslim etme yerini seçin</option>
                                    <option value="İstanbul Havalimanı">İstanbul Havalimanı</option>
                                    <option value="Sabiha Gökçen Havalimanı">Sabiha Gökçen Havalimanı</option>
                                    <option value="İstanbul Taksim">İstanbul Taksim</option>
                                    <option value="İstanbul Kadıköy">İstanbul Kadıköy</option>
                                    <option value="Ankara Esenboğa Havalimanı">Ankara Esenboğa Havalimanı</option>
                                    <option value="İzmir Adnan Menderes Havalimanı">İzmir Adnan Menderes Havalimanı</option>
                                    <option value="Antalya Havalimanı">Antalya Havalimanı</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_time" class="form-label fw-bold">
                                    <i class="fas fa-clock me-1 text-primary"></i> Teslim Alma Saati
                                </label>
                                <select class="form-select" id="pickup_time" name="pickup_time" required>
                                    <option value="">Teslim alma saatini seçin</option>
                                    @foreach(['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'] as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_time" class="form-label fw-bold">
                                    <i class="fas fa-clock me-1 text-primary"></i> Teslim Etme Saati
                                </label>
                                <select class="form-select" id="return_time" name="return_time" required>
                                    <option value="">Teslim etme saatini seçin</option>
                                    @foreach(['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'] as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-shield-alt me-1 text-primary"></i> Ek Hizmetler
                            </label>
                            
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="additional_driver" name="additional_driver" value="1">
                                        <label class="form-check-label d-flex justify-content-between" for="additional_driver">
                                            <span>Ek Sürücü</span>
                                            <span class="text-primary fw-bold">+150 ₺</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="navigation" name="navigation" value="1">
                                        <label class="form-check-label d-flex justify-content-between" for="navigation">
                                            <span>Navigasyon</span>
                                            <span class="text-primary fw-bold">+100 ₺</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="baby_seat" name="baby_seat" value="1">
                                        <label class="form-check-label d-flex justify-content-between" for="baby_seat">
                                            <span>Bebek Koltuğu</span>
                                            <span class="text-primary fw-bold">+120 ₺</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-light border mb-4">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Toplam Gün:</span>
                                <span id="totalDays">1 gün</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                <span>Toplam Tutar:</span>
                                <span class="text-primary" id="totalPrice">{{ number_format($car->price_per_day, 2) }} ₺</span>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Rezervasyonu Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 order-lg-2 order-1 mb-4 mb-lg-0">
            <!-- Araç Bilgileri -->
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
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
                        <h3 class="h4 mb-3">{{ $car->brand }} {{ $car->model }}</h3>
                        
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-calendar me-1"></i> {{ $car->year }}
                            </span>
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-gas-pump me-1"></i> {{ $car->fuel_type ?? 'Belirtilmemiş' }}
                            </span>
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-cog me-1"></i> {{ $car->transmission ?? 'Belirtilmemiş' }}
                            </span>
                        </div>
                        
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                <span><i class="fas fa-car-side me-2 text-primary"></i>Marka:</span>
                                <span class="fw-bold">{{ $car->brand }}</span>
                            </li>
                            <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                <span><i class="fas fa-car me-2 text-primary"></i>Model:</span>
                                <span class="fw-bold">{{ $car->model }}</span>
                            </li>
                            <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                <span><i class="fas fa-users me-2 text-primary"></i>Koltuk:</span>
                                <span class="fw-bold">{{ $car->seats ?? 5 }} kişilik</span>
                            </li>
                            <li class="list-group-item border-0 px-0 py-1 d-flex justify-content-between">
                                <span><i class="fas fa-money-bill-wave me-2 text-primary"></i>Günlük Ücret:</span>
                                <span class="fw-bold">{{ number_format($car->price_per_day, 2) }} ₺</span>
                            </li>
                        </ul>
                        
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Araç özellikleri ve fiyatlandırma yukarıdaki gibidir. Lütfen rezervasyon tarihlerinizi ve ek hizmetlerinizi seçin.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalDaysEl = document.getElementById('totalDays');
        const totalPriceEl = document.getElementById('totalPrice');
        const pricePerDay = {{ $car->price_per_day }};
        
        // Set minimum end date to be the day after the selected start date
        startDateInput.addEventListener('change', function() {
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            
            const year = nextDay.getFullYear();
            const month = String(nextDay.getMonth() + 1).padStart(2, '0');
            const day = String(nextDay.getDate()).padStart(2, '0');
            
            endDateInput.min = `${year}-${month}-${day}`;
            
            // If end date is less than new minimum, update it
            if (endDateInput.value < endDateInput.min) {
                endDateInput.value = endDateInput.min;
            }
            
            calculateTotal();
        });
        
        endDateInput.addEventListener('change', calculateTotal);
        
        // Add event listeners for additional services
        document.getElementById('additional_driver').addEventListener('change', calculateTotal);
        document.getElementById('navigation').addEventListener('change', calculateTotal);
        document.getElementById('baby_seat').addEventListener('change', calculateTotal);
        
        function calculateTotal() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            // Calculate difference in days
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            // Update total days display
            totalDaysEl.textContent = diffDays + ' gün';
            
            // Calculate total price (days * price per day)
            let totalPrice = diffDays * pricePerDay;
            
            // Add costs for additional services
            if (document.getElementById('additional_driver').checked) totalPrice += 150;
            if (document.getElementById('navigation').checked) totalPrice += 100;
            if (document.getElementById('baby_seat').checked) totalPrice += 120;
            
            // Update total price display
            totalPriceEl.textContent = totalPrice.toLocaleString('tr-TR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' ₺';
        }
        
        // Run calculation on page load
        calculateTotal();
    });
</script>
@endpush
