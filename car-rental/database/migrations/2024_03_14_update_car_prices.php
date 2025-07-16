<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Tüm araçların fiyatlarını güncelle
        DB::table('cars')->where('price_per_day', 0)->update([
            'price_per_day' => 500.00 // Varsayılan günlük fiyat
        ]);
    }

    public function down()
    {
        // Geri alma işlemi gerekmiyor
    }
}; 