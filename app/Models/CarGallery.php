<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarGallery extends Model
{
    public function getImageUrlAttribute()
    {
        if (strpos($this->path, 'http') === 0) {
            return $this->path;
        }
        
        return asset('storage/' . $this->path);
    }
} 