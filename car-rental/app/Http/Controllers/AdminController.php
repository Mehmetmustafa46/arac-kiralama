<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $reservations = Reservation::with('user')->get();
        $cars = Car::all();
        
        return view('admin.dashboard', compact('users', 'reservations', 'cars'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function reservations()
    {
        $reservations = Reservation::with('user')->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $user->update([
            'is_admin' => $request->has('is_admin')
        ]);

        return back()->with('success', 'Kullanıcı durumu güncellendi.');
    }
    
    public function settings()
    {
        return view('admin.settings');
    }
    
    public function updateSettings(Request $request)
    {
        // Burada ayarları veritabanına veya .env dosyasına kaydedeceğiz
        // Örnek olarak sadece başarılı mesajı dönüyoruz
        
        // Cache'i temizleyelim
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        return back()->with('success', 'Ayarlar başarıyla güncellendi.');
    }
}
