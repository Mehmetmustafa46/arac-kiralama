<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Araç listesini göster
     */
    public function index()
    {
        $cars = Car::orderBy('id', 'desc')->get();
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Yeni araç ekleme formunu göster
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Yeni aracı veritabanına kaydet
     */
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
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'nullable|string',
            ]);

            $data = $request->except('image');
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('cars', 'public');
                $data['image_url'] = $path;
            }

            $car = Car::create($data);

            return redirect()->route('admin.cars.index')
                ->with('success', 'Araç başarıyla eklendi.');
        } catch (\Exception $e) {
            // Hatayı logla
            \Log::error('Araç eklenirken hata oluştu: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Araç eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Araç detaylarını göster
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Araç düzenleme formunu göster
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Aracı güncelle
     */
    public function update(Request $request, string $id)
    {
        $car = Car::findOrFail($id);
        
        // Sadece durum güncellemesi yapılıyorsa kısa bir doğrulama uygula
        if ($request->has('status') && count($request->all()) <= 3) { // _token, _method ve status gelebilir
            $request->validate([
                'status' => 'required|in:available,rented,maintenance',
            ]);
            
            $car->update([
                'status' => $request->status
            ]);
            
            return redirect()->back()->with('success', 'Araç durumu başarıyla güncellendi.');
        }
        
        // Tam güncelleme için kapsamlı doğrulama
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price_per_day' => 'required|numeric|min:0',
            'fuel_type' => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'seats' => 'required|integer|min:1|max:50',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except(['image', '_token', '_method']);
        
        if ($request->hasFile('image')) {
            if ($car->image_url && Storage::disk('public')->exists($car->image_url)) {
                Storage::disk('public')->delete($car->image_url);
            }
            
            $path = $request->file('image')->store('cars', 'public');
            $data['image_url'] = $path;
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Araç başarıyla güncellendi.');
    }

    /**
     * Aracı sil
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Araç başarıyla silindi.');
    }
    
    /**
     * Aracın galeri yönetim sayfasına yönlendir
     */
    public function gallery(string $id)
    {
        return redirect()->route('admin.gallery.index', $id);
    }
}
