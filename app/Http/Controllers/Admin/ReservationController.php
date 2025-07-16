<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $reservation->update($validated);

        // Eğer rezervasyon iptal edildiyse veya tamamlandıysa aracın durumunu güncelle
        if ($validated['status'] === 'cancelled' || $validated['status'] === 'completed') {
            $reservation->vehicle->update(['status' => 'available']);
        }
        // Eğer rezervasyon onaylandıysa aracın durumunu kirada olarak güncelle
        elseif ($validated['status'] === 'confirmed') {
            $reservation->vehicle->update(['status' => 'rented']);
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Rezervasyon durumu başarıyla güncellendi.');
    }
} 