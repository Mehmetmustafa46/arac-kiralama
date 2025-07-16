<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->decimal('price_per_day', 10, 2);
            $table->enum('fuel_type', ['benzin', 'dizel', 'elektrik', 'hybrid']);
            $table->enum('transmission', ['manuel', 'otomatik']);
            $table->integer('seats');
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
