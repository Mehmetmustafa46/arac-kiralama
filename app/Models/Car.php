// ... existing code ...
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
        'type',
    ];

    // Araç tipleri için sabitler
    const TIP_SEDAN = 'sedan';
    const TIP_SUV = 'suv';
    const TIP_HATCHBACK = 'hatchback';
    const TIP_COUPE = 'coupe';

    /**
     * Araç tipleri için kullanılabilir değerler
     */
    public static function getTipSecenekleri()
    {
        return [
            self::TIP_SEDAN => 'Sedan',
            self::TIP_SUV => 'SUV',
            self::TIP_HATCHBACK => 'Hatchback',
            self::TIP_COUPE => 'Coupe',
        ];
    }

    public function getImageUrlAttribute()
    {
        // Galeri tablosunda birincil görsel var mı kontrol et
        $primaryGalleryImage = $this->gallery()->where('is_primary', true)->first();
        if ($primaryGalleryImage) {
            if (strpos($primaryGalleryImage->path, 'http') === 0) {
                return $primaryGalleryImage->path;
            }
            return asset('storage/' . $primaryGalleryImage->path);
        }
        
        // İmages tablosunda birincil görsel var mı kontrol et
        $primaryImage = $this->images()->where('is_primary', true)->first();
        if ($primaryImage) {
            if (strpos($primaryImage->path, 'http') === 0) {
                return $primaryImage->path;
            }
            return asset('storage/' . $primaryImage->path);
        }
        
        // Image URL değeri varsa onu kullan
        if (!empty($this->attributes['image_url'])) {
            if (strpos($this->attributes['image_url'], 'http') === 0) {
                return $this->attributes['image_url'];
            }
            return asset('storage/' . $this->attributes['image_url']);
        }
        
        // Hiçbiri yoksa varsayılan görsel
        return 'https://via.placeholder.com/300x200?text=Araç+Görseli';
    }

    /**
     * Araca ait tüm rezervasyonlar
     */
    public function rezervasyonlar()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Aracın sahibi/yöneticisi
     */
    public function yonetici()
    {
        return $this->belongsTo(User::class, 'yonetici_id');
    }

    /**
     * Aracın bakım kayıtları
     */
    public function bakimKayitlari()
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Aracın fotoğraf galerisi
     */
    public function fotograflar()
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * Aracın özellik detayları
     */
    public function ozellikler()
    {
        return $this->hasMany(CarFeature::class);
    }

    /**
     * Aracın mevcut durumunu kontrol et
     */
    public function musaitMi()
    {
        return $this->status === 'available';
    }

    /**
     * Aracın toplam rezervasyon sayısı
     */
    public function toplamRezervasyonSayisi()
    {
        return $this->rezervasyonlar()->count();
    }

    /**
     * Aracın ortalama puanı
     */
    public function ortalamaYildiz()
    {
        return $this->rezervasyonlar()->avg('rating') ?? 0;
    }
// ... existing code ...