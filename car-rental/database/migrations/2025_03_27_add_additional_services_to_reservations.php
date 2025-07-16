<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->boolean('additional_driver')->default(false);
            $table->boolean('navigation')->default(false);
            $table->boolean('baby_seat')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['additional_driver', 'navigation', 'baby_seat']);
        });
    }
}; 