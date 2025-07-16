@extends('layouts.admin')

@section('title', 'Rezervasyon Detayı')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rezervasyon Detayı #{{ $reservation->id }}</h5>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Geri</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Müşteri Bilgileri</h6>
                            <p><strong>Ad Soyad:</strong> {{ $reservation->user->name }}</p>
                            <p><strong>E-posta:</strong> {{ $reservation->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Araç Bilgileri</h6>
                            <p><strong>Marka/Model:</strong> {{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}</p>
                            <p><strong>Yıl:</strong> {{ $reservation->vehicle->year }}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Rezervasyon Tarihleri</h6>
                            <p><strong>Başlangıç:</strong> {{ $reservation->start_date->format('d.m.Y') }}</p>
                            <p><strong>Bitiş:</strong> {{ $reservation->end_date->format('d.m.Y') }}</p>
                            <p><strong>Toplam Gün:</strong> {{ $reservation->start_date->diffInDays($reservation->end_date) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ödeme Bilgileri</h6>
                            <p><strong>Günlük Ücret:</strong> {{ number_format($reservation->vehicle->price_per_day, 2) }} ₺</p>
                            <p><strong>Toplam Ücret:</strong> {{ number_format($reservation->total_price, 2) }} ₺</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Durum</h6>
                        @switch($reservation->status)
                            @case('pending')
                                <span class="badge bg-warning">Beklemede</span>
                                @break
                            @case('approved')
                            @case('confirmed')
                                <span class="badge bg-success">Onaylandı</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">İptal Edildi</span>
                                @break
                            @case('completed')
                                <span class="badge bg-info">Tamamlandı</span>
                                @break
                            @case('rented')
                                <span class="badge bg-primary">Kirada</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Bilinmiyor</span>
                        @endswitch
                    </div>
                    <div class="mb-2">
                        <h6 class="text-muted">Durum Güncelle</h6>
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-warning">Beklemede</button>
                        </form>
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success">Onayla</button>
                        </form>
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger">İptal Et</button>
                        </form>
                        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-info">Tamamlandı</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 