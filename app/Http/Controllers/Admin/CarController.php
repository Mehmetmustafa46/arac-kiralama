<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'price_per_day' => 'required|numeric|min:0',
                'fuel_type' => 'required|string|max:50',
                'transmission' => 'required|string|max:50',
                'seats' => 'required|integer|min:1|max:50',
                'status' => 'required|in:available,reserved,maintenance',
                'image_url' => 'required|url|max:2048',
                'description' => 'nullable|string',
            ]);

            $car = Car::create($validated);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Araç başarıyla eklendi.');
        } catch (\Exception $e) {
            // Hatayı logla
            \Log::error('Araç eklenirken hata oluştu: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Araç eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Car $car)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:available,maintenance'
            ]);

            $car->update($validated);

            return redirect()->back()
                ->with('success', 'Araç durumu başarıyla güncellendi.');
        } catch (\Exception $e) {
            \Log::error('Araç durumu güncellenirken hata oluştu: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Araç durumu güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 