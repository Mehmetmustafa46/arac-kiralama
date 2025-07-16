<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'rating',
        'comment',
    ];

    // Yorum kullanıcıya bağlı
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Yorum araca bağlı
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
