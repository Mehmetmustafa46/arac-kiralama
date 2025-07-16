<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate_number',
        'color',
        'daily_price',
        'status',
        'description',
    ];

    protected $casts = [
        'year' => 'integer',
        'daily_price' => 'decimal:2',
    ];

    /**
     * Aracın reservasyonları
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'car_id');
    }

    /**
     * İş müsait mi kontrolü
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * İs rented kontrolü
     */
    public function isRented()
    {
        return $this->status === 'rented';
    }

    /**
     * Bakımda mı kontrolü
     */
    public function isInMaintenance()
    {
        return $this->status === 'maintenance';
    }
} 