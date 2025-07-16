<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();
        
        // Durum filtresi - varsayılan olarak müsait araçları göster
        $query->where('status', 'available');
        
        // Sıralama
        $sortBy = $request->input('sort', 'price_asc'); // Varsayılan sıralama: artan fiyat
        switch ($sortBy) {
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'year_new':
                $query->orderBy('year', 'desc');
                break;
            case 'year_old':
                $query->orderBy('year', 'asc');
                break;
            default:
                $query->orderBy('price_per_day', 'asc');
        }
        
        // Yakıt tipi filtresi
        if ($request->filled('fuel_type')) {
            // İngilizce fuel_type değerini Türkçe karşılığına çevir
            $fuelTypeMapping = [
                'petrol' => 'benzin',
                'diesel' => 'dizel',
                'electric' => 'elektrik',
                'hybrid' => 'hybrid'
            ];
            
            $fuelType = $request->fuel_type;
            if (array_key_exists($fuelType, $fuelTypeMapping)) {
                $fuelType = $fuelTypeMapping[$fuelType];
            }
            
            $query->where('fuel_type', $fuelType);
        }
        
        // Vites tipi filtresi
        if ($request->filled('transmission')) {
            // İngilizce transmission değerini Türkçe karşılığına çevir
            $transmissionMapping = [
                'manual' => 'manuel',
                'automatic' => 'otomatik'
            ];
            
            $transmission = $request->transmission;
            if (array_key_exists($transmission, $transmissionMapping)) {
                $transmission = $transmissionMapping[$transmission];
            }
            
            $query->where('transmission', $transmission);
        }
        
        // Diğer filtreler buraya eklenebilir
        // Tarih aralığı filtresi, fiyat aralığı vb.
        
        $cars = $query->get();
        
        return view('cars.index', compact('cars', 'sortBy'));
    }

    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }
}

