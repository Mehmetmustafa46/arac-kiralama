<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'path',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    /**
     * Fotoğrafın ait olduğu araç
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    // Görüntü URL'si için accessor
    public function getImageUrlAttribute()
    {
        if (strpos($this->path, 'http') === 0) {
            return $this->path;
        }
        
        return url('storage/' . $this->path);
    }
} 