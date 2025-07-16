<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Toplam istatistikler - Varol Rent veritabanından
            $stats = [
                'total_users' => DB::connection('varolrent')->table('users')->count(),
                'total_reservations' => DB::connection('varolrent')->table('reservations')->count(),
                'active_reservations' => DB::connection('varolrent')->table('reservations')
                    ->where('status', 'active')->count(),
                'total_cars' => DB::connection('varolrent')->table('cars')->count(),
            ];

            // Haftalık rezervasyon istatistikleri
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            
            $weeklyStats = [];
            $days = ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'];
            
            // Her gün için varsayılan 0 değeri ata
            foreach ($days as $day) {
                $weeklyStats[$day] = 0;
            }
            
            // Varol Rent veritabanından rezervasyon istatistiklerini al
            $dbStats = DB::connection('varolrent')
                ->table('reservations')
                ->select(
                    DB::raw('DATE(created_at) as tarih'),
                    DB::raw('count(*) as toplam')
                )
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('tarih')
                ->get();
            
            foreach ($dbStats as $stat) {
                $dayName = Carbon::parse($stat->tarih)->locale('tr')->shortDayName;
                $weeklyStats[$dayName] = $stat->toplam;
            }

            // Araç tipi dağılımı - Varol Rent veritabanından
            $carTypes = DB::connection('varolrent')
                ->table('cars')
                ->select('type', DB::raw('count(*) as toplam'))
                ->groupBy('type')
                ->get()
                ->mapWithKeys(function ($item) {
                    $tip = match($item->type) {
                        'sedan' => 'Sedan',
                        'suv' => 'SUV',
                        'hatchback' => 'Hatchback',
                        'coupe' => 'Coupe',
                        default => ucfirst($item->type)
                    };
                    return [$tip => $item->toplam];
                })
                ->toArray();

            // Son rezervasyonlar - Varol Rent veritabanından
            $latestReservations = DB::connection('varolrent')
                ->table('reservations')
                ->join('users', 'reservations.user_id', '=', 'users.id')
                ->join('cars', 'reservations.car_id', '=', 'cars.id')
                ->select(
                    'reservations.id',
                    'users.name as kullanici',
                    'users.profile_photo_url as kullanici_avatar',
                    DB::raw("CONCAT(cars.brand, ' ', cars.model) as arac"),
                    'cars.image_url as arac_foto',
                    'reservations.start_date as baslangic',
                    'reservations.end_date as bitis',
                    'reservations.total_price as tutar',
                    'reservations.status as durum'
                )
                ->latest('reservations.created_at')
                ->take(10)
                ->get()
                ->map(function ($reservation) {
                    return [
                        'id' => $reservation->id,
                        'kullanici' => $reservation->kullanici ?? 'Bilinmeyen Kullanıcı',
                        'kullanici_avatar' => $reservation->kullanici_avatar ?? asset('images/default-avatar.png'),
                        'arac' => $reservation->arac ?? 'Silinmiş Araç',
                        'arac_foto' => $reservation->arac_foto ?? asset('images/default-car.png'),
                        'baslangic' => Carbon::parse($reservation->baslangic)->format('d.m.Y'),
                        'bitis' => Carbon::parse($reservation->bitis)->format('d.m.Y'),
                        'tutar' => number_format($reservation->tutar, 2, ',', '.'),
                        'durum' => $reservation->durum ?? 'beklemede',
                        'durum_renk' => $this->getStatusColor($reservation->durum),
                        'durum_metin' => $this->getStatusText($reservation->durum)
                    ];
                });

            return view('admin.dashboard', compact(
                'stats',
                'weeklyStats',
                'carTypes',
                'latestReservations'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return view('admin.dashboard')->with('error', 'Gösterge paneli yüklenirken bir hata oluştu.');
        }
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'active' => 'success',
            'pending' => 'warning',
            'completed' => 'info',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    private function getStatusText($status)
    {
        return match($status) {
            'active' => 'Aktif',
            'pending' => 'Beklemede',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal Edildi',
            default => 'Bilinmiyor'
        };
    }
} 