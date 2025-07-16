<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'last_four_digits',
    ];

    // Ödeme rezervasyona bağlı
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Ödeme kullanıcıya bağlı
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
