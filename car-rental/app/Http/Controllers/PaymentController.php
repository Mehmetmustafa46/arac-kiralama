<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function create($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        // Sadece kendi rezervasyonunun ödemesini yapabilir
        if ($reservation->user_id !== auth()->id()) {
            return redirect()->route('reservations.index')
                ->with('error', 'Bu rezervasyon için ödeme yapma yetkiniz yok.');
        }

        // Rezervasyon zaten ödenmişse
        if ($reservation->payment) {
            return redirect()->route('reservations.index')
                ->with('error', 'Bu rezervasyon zaten ödenmiş.');
        }

        return view('payments.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'reservation_id' => 'required|exists:reservations,id',
                'card_number' => 'required|string|size:16',
                'expiry_month' => 'required|integer|min:1|max:12',
                'expiry_year' => 'required|integer|min:' . date('Y'),
                'cvv' => 'required|string|size:3',
                'card_holder_name' => 'required|string|max:255'
            ]);

            $reservation = Reservation::findOrFail($validated['reservation_id']);

            // Sadece kendi rezervasyonunun ödemesini yapabilir
            if ($reservation->user_id !== auth()->id()) {
                return redirect()->route('reservations.index')
                    ->with('error', 'Bu rezervasyon için ödeme yapma yetkiniz yok.');
            }

            // Rezervasyon zaten ödenmişse
            if ($reservation->payment) {
                return redirect()->route('reservations.index')
                    ->with('error', 'Bu rezervasyon için zaten ödeme yapılmış.');
            }

            DB::beginTransaction();

            // Kredi kartı numarasının son 4 hanesini sakla
            $lastFourDigits = substr($validated['card_number'], -4);

            // Ödeme kaydı oluştur
            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'user_id' => auth()->id(),
                'amount' => $reservation->total_price,
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'transaction_id' => 'TR' . time() . rand(1000, 9999), // Basit bir transaction ID
                'last_four_digits' => $lastFourDigits,
            ]);

            // Rezervasyon durumunu güncelle
            $reservation->update([
                'status' => 'confirmed'
            ]);

            // Aracın durumunu güncelle
            $reservation->car->update([
                'status' => 'rented'
            ]);

            DB::commit();

            return redirect()->route('reservations.show', $reservation->id)
                ->with('success', 'Ödeme başarıyla tamamlandı. Rezervasyonunuz onaylandı!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Ödeme işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
}
