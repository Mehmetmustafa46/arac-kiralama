<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarGalleryController extends Controller
{
    /**
     * Belirli bir aracın galeri fotoğraflarını listeler
     */
    public function index($carId)
    {
        $car = Car::findOrFail($carId);
        $gallery = $car->gallery()->orderBy('display_order')->get();
        
        return view('admin.gallery.index', compact('car', 'gallery'));
    }

    /**
     * Yeni fotoğraf yükleme formunu gösterir
     */
    public function create($carId)
    {
        $car = Car::findOrFail($carId);
        return view('admin.gallery.create', compact('car'));
    }

    /**
     * Yeni fotoğraf yükler
     */
    public function store(Request $request, $carId)
    {
        try {
            $car = Car::findOrFail($carId);
            
            \Log::info('Galeri fotoğraf yükleme isteği başladı. Car ID: ' . $carId);
            \Log::info('Form verileri:', $request->all());
            
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'title' => 'nullable|string|max:255',
                'display_order' => 'nullable|integer|min:0',
                'is_primary' => 'nullable',
            ]);
            
            // Form validation geçti, dosya kontrolü yapalım
            if (!$request->hasFile('image')) {
                \Log::error('Fotoğraf yükleme hatası: form validation geçti ama dosya bulunamadı');
                return back()->withInput()->with('error', 'Lütfen bir fotoğraf seçiniz.');
            }
            
            $file = $request->file('image');
            
            // Dosya geçerli mi kontrol et
            if (!$file->isValid()) {
                \Log::error('Fotoğraf yükleme hatası: Dosya geçerli değil');
                return back()->withInput()->with('error', 'Yüklenen dosya geçerli değil. Lütfen başka bir dosya seçin.');
            }
            
            // Eğer ana görüntü olarak işaretlendiyse, diğer tüm görüntüleri ana değil olarak ayarla
            if ($request->has('is_primary')) {
                $car->gallery()->update(['is_primary' => false]);
            }
            
            // En yüksek display_order değerini bul
            $maxOrder = $car->gallery()->max('display_order') ?? 0;
            
            // Dosya yükleme işlemini debug
            \Log::info('Dosya bilgileri:', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension()
            ]);
            
            // Public storage dizininin varlığını kontrol et
            $storagePath = storage_path('app/public/gallery');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
                \Log::info('Storage dizini oluşturuldu: ' . $storagePath);
            }
            
            try {
                // Görüntüyü upload et
                $path = $file->store('gallery', 'public');
                \Log::info('Dosya başarıyla yüklendi: ' . $path);
                
                // Veritabanına kaydet
                $gallery = new CarGallery([
                    'car_id' => $car->id,
                    'path' => $path,
                    'title' => $request->title,
                    'display_order' => $request->display_order ?? ($maxOrder + 1),
                    'is_primary' => $request->has('is_primary'),
                    'is_active' => true,
                ]);
                
                $gallery->save();
                \Log::info('Galeri kaydı başarıyla oluşturuldu. ID: ' . $gallery->id);
                
                return redirect()->route('admin.gallery.index', $car->id)
                    ->with('success', 'Fotoğraf başarıyla yüklendi.');
            } catch (\Exception $e) {
                \Log::error('Dosya yükleme veya veritabanı hatası: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withInput()->with('error', 'Dosya yüklenirken bir hata oluştu: ' . $e->getMessage());
            }
                
        } catch (\Exception $e) {
            \Log::error('Genel hata: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Fotoğraf düzenleme formunu gösterir
     */
    public function edit($carId, $id)
    {
        $car = Car::findOrFail($carId);
        $image = CarGallery::findOrFail($id);
        
        return view('admin.gallery.edit', compact('car', 'image'));
    }

    /**
     * Fotoğraf bilgilerini günceller
     */
    public function update(Request $request, $carId, $id)
    {
        $car = Car::findOrFail($carId);
        $image = CarGallery::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'display_order' => 'required|integer|min:0',
            'is_primary' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Eğer ana görüntü olarak işaretlendiyse, diğer tüm görüntüleri ana değil olarak ayarla
        if ($request->has('is_primary')) {
            $car->gallery()->where('id', '!=', $image->id)->update(['is_primary' => false]);
        }
        
        // Eğer yeni bir görüntü yüklendiyse eskisini sil
        if ($request->hasFile('image')) {
            // Eski dosyayı sil (eğer dış URL değilse)
            if (strpos($image->path, 'http') !== 0) {
                Storage::disk('public')->delete($image->path);
            }
            
            // Yeni görüntüyü kaydet
            $path = $request->file('image')->store('gallery', 'public');
            $image->path = $path;
        }
        
        // Diğer bilgileri güncelle
        $image->title = $request->title;
        $image->display_order = $request->display_order;
        $image->is_primary = $request->has('is_primary');
        
        $image->save();
        
        return redirect()->route('admin.gallery.index', $car->id)
            ->with('success', 'Fotoğraf başarıyla güncellendi.');
    }

    /**
     * Fotoğrafı siler
     */
    public function destroy($carId, $id)
    {
        $photo = CarGallery::findOrFail($id);
        
        // Dosyayı sil (eğer dış URL değilse)
        if (strpos($photo->path, 'http') !== 0) {
            Storage::disk('public')->delete($photo->path);
        }
        
        $photo->delete();
        
        return redirect()->route('admin.gallery.index', $carId)
            ->with('success', 'Fotoğraf başarıyla silindi.');
    }
}
