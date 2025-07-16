<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarGallery extends Model
{
    use HasFactory;
    
    protected $table = 'car_gallery';

    protected $fillable = [
        'car_id',
        'path',
        'title',
        'description',
        'display_order',
        'is_primary',
        'is_active',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Car ilişkisi
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
        
        return Storage::url($this->path);
    }
}
