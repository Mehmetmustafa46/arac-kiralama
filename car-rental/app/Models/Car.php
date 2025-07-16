<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price_per_day',
        'fuel_type',
        'transmission',
        'seats',
        'status',
        'image_url',
        'description',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
    ];

    // Bir arabanın birden fazla rezervasyonu olabilir
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Araba yorumlarla ilişkilendirildi
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Araba galerisi ilişkisi
    public function gallery()
    {
        return $this->hasMany(CarGallery::class);
    }

    // Ana galeri görüntüsünü getir
    public function primaryImage()
    {
        return $this->hasOne(CarGallery::class)->where('is_primary', true);
    }

    // Image URL accessor'ı
    public function getImageUrlAttribute()
    {
        $primaryGalleryImage = $this->gallery()->where('is_primary', true)->first();
        if ($primaryGalleryImage) {
            return url('storage/' . $primaryGalleryImage->path);
        }

        $primaryImage = $this->images()->where('is_primary', true)->first();
        if ($primaryImage) {
            return url('storage/' . $primaryImage->path);
        }

        if (!empty($this->attributes['image_url'])) {
            return url('storage/' . $this->attributes['image_url']);
        }

        // Hiçbiri yoksa varsayılan görsel
        return 'https://via.placeholder.com/300x200?text=Araç+Görseli';
    }

    /**
     * Araç fotoğrafları ilişkisi
     */
    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * Ana fotoğrafı al
     */
    public function getPrimaryImageAttribute()
    {

        return null;
    }

    /**
     * Araç durumu için kullanılabilir değerler
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';

    /**
     * Araç durumu için kullanılabilir değerler
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_AVAILABLE => 'Müsait',
            self::STATUS_RENTED => 'Kirada',
            self::STATUS_MAINTENANCE => 'Bakımda',
        ];
    }
}
