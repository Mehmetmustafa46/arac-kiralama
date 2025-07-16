@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sistem Ayarları</h1>
    </div>

    <div class="row g-4">
        <!-- Genel Ayarlar -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Genel Ayarlar</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Adı</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ config('app.name') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="site_description" class="form-label">Site Açıklaması</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3">Araç Kiralama Sistemi</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">İletişim E-posta</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="info@arackiralama.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">İletişim Telefon</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="+90 (555) 123 4567">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Rezervasyon Ayarları -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Rezervasyon Ayarları</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="min_reservation_days" class="form-label">Minimum Kiralama Süresi (gün)</label>
                            <input type="number" class="form-control" id="min_reservation_days" name="min_reservation_days" value="1" min="1">
                        </div>
                        
                        <div class="mb-3">
                            <label for="max_reservation_days" class="form-label">Maksimum Kiralama Süresi (gün)</label>
                            <input type="number" class="form-control" id="max_reservation_days" name="max_reservation_days" value="30" min="1">
                        </div>
                        
                        <div class="mb-3">
                            <label for="reservation_tax_rate" class="form-label">Vergi Oranı (%)</label>
                            <input type="number" class="form-control" id="reservation_tax_rate" name="reservation_tax_rate" value="18" min="0" max="100">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="require_payment_upfront" name="require_payment_upfront" checked>
                            <label class="form-check-label" for="require_payment_upfront">Rezervasyon için ödeme zorunlu</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sistem Bilgileri -->
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sistem Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>PHP Versiyonu:</strong> {{ phpversion() }}</p>
                            <p><strong>Laravel Versiyonu:</strong> {{ app()->version() }}</p>
                            <p><strong>Veritabanı:</strong> {{ config('database.connections.mysql.driver') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Son Güncelleme:</strong> {{ date('d.m.Y H:i') }}</p>
                            <p><strong>Toplam Kullanıcı:</strong> {{ \App\Models\User::count() }}</p>
                            <p><strong>Toplam Araç:</strong> {{ \App\Models\Car::count() }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Aktif Rezervasyonlar:</strong> {{ \App\Models\Reservation::where('status', 'active')->count() }}</p>
                            <p><strong>Toplam Rezervasyon:</strong> {{ \App\Models\Reservation::count() }}</p>
                            <p><strong>Server IP:</strong> {{ $_SERVER['SERVER_ADDR'] ?? 'localhost' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection