<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'pickup_location',
        'return_location',
        'pickup_time',
        'return_time',
        'total_price',
        'status',
        'additional_driver',
        'navigation',
        'baby_seat',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // StatusColor accessor
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
        ][$this->status] ?? 'secondary';
    }

    // StatusText accessor
    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Onay Bekliyor',
            'confirmed' => 'Onaylandı',
            'cancelled' => 'İptal Edildi',
            'completed' => 'Tamamlandı',
        ][$this->status] ?? 'Bilinmiyor';
    }

    // Total Amount accessor (total_price için bir alias)
    public function getTotalAmountAttribute()
    {
        return $this->total_price;
    }

    // Kiralama süresi (gün sayısı)
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    // Rezervasyon kullanıcı ile ilişkilendirildi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Rezervasyon araca bağlı
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Vehicle car'ın bir alias'ı olarak tanımlanıyor
    public function vehicle()
    {
        return $this->car();
    }

    // Ödeme ile bağlantı
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
