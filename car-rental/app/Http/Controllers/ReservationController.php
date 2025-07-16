<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Car;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth()->user()->reservations()->paginate(6);
        return view('reservations.index', compact('reservations'));
    }

    public function create($carId)
    {
        $car = Car::findOrFail($carId);
        return view('reservations.create', compact('car'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string',
            'return_location' => 'required|string',
            'pickup_time' => 'required|string',
            'return_time' => 'required|string',
            'additional_driver' => 'nullable|boolean',
            'navigation' => 'nullable|boolean',
            'baby_seat' => 'nullable|boolean',
        ]);

        $car = Car::findOrFail($request->car_id);

        // Tarih aralığını hesapla (gün sayısı)
        $startDate = strtotime($request->start_date);
        $endDate = strtotime($request->end_date);
        $durationInDays = ceil(($endDate - $startDate) / 86400);

        // Toplam ücreti hesapla
        $totalPrice = $durationInDays * $car->price_per_day;

        // Ek hizmetlerin ücretlerini ekle
        if ($request->additional_driver) {
            $totalPrice += 150;
        }
        if ($request->navigation) {
            $totalPrice += 100;
        }
        if ($request->baby_seat) {
            $totalPrice += 120;
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'pickup_time' => $request->pickup_time,
            'return_time' => $request->return_time,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Rezervasyon başarıyla oluşturuldu! Lütfen ödeme işlemini tamamlayınız.');
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Kullanıcının kendi rezervasyonlarını görebilmesi için yetki kontrolü
        if ($reservation->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Bu rezervasyonu görüntüleme yetkiniz yok.');
        }
        
        return view('reservations.show', compact('reservation'));
    }
    
    // Ödeme işlemini tamamlama
    public function pay($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Sadece kendi rezervasyonlarını ödeyebilmesi için kontrol
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Bu rezervasyon için ödeme yapamazsınız.');
        }
        
        // Eğer zaten onaylanmış veya tamamlanmış ise, tekrar ödeme yapılmamalı
        if ($reservation->status !== 'pending') {
            return redirect()->route('reservations.show', $reservation->id)
                ->with('error', 'Bu rezervasyon için zaten ödeme yapılmış veya iptal edilmiş.');
        }
        
        // Ödeme sayfasına yönlendir
        return redirect()->route('payments.create', $reservation->id);
    }
    
    // Rezervasyon iptali
    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Sadece kendi rezervasyonlarını iptal edebilmesi için kontrol
        if ($reservation->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Bu rezervasyonu iptal etme yetkiniz yok.');
        }
        
        // Eğer zaten iptal edilmiş veya tamamlanmış ise, tekrar iptal edilmemeli
        if ($reservation->status === 'cancelled' || $reservation->status === 'completed') {
            return redirect()->route('reservations.show', $reservation->id)
                ->with('error', 'Bu rezervasyon zaten iptal edilmiş veya tamamlanmış.');
        }
        
        $reservation->update([
            'status' => 'cancelled',
        ]);
        
        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Rezervasyonunuz başarıyla iptal edildi.');
    }
}
