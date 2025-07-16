<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::orderBy('brand')->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'color' => 'required|string|max:30',
            'daily_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Araç başarıyla eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'color' => 'required|string|max:30',
            'daily_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Araç başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Araç başarıyla silindi.');
    }
} 