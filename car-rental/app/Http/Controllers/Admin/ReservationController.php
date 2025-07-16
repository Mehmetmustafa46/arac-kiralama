<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'vehicle'])->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'vehicle']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,cancelled,completed'
        ]);

        $reservation->update($validated);

        // Eğer rezervasyon iptal edildiyse veya tamamlandıysa aracın durumunu güncelle
        if ($validated['status'] === 'cancelled' || $validated['status'] === 'completed') {
            $reservation->vehicle->update(['status' => 'available']);
        }
        // Eğer rezervasyon onaylandıysa aracın durumunu kirada olarak güncelle
        elseif ($validated['status'] === 'approved') {
            $reservation->vehicle->update(['status' => 'rented']);
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Rezervasyon durumu başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Rezervasyon silindiğinde aracın durumunu müsait olarak güncelle
        $reservation->vehicle->update(['status' => 'available']);
        
        $reservation->delete();
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Rezervasyon başarıyla silindi.');
    }
}
