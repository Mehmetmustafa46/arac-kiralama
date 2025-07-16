<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand');              // Marka
            $table->string('model');              // Model
            $table->integer('year');              // Yıl
            $table->string('plate_number');       // Plaka
            $table->string('color');              // Renk
            $table->decimal('daily_price', 10, 2); // Günlük Kiralama Ücreti
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available'); // Durum
            $table->text('description')->nullable(); // Açıklama
            $table->timestamps();
            $table->softDeletes(); // Silinen araçları takip etmek için
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
