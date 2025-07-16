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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('pickup_location')->nullable()->after('end_date');
            $table->string('return_location')->nullable()->after('pickup_location');
            $table->string('pickup_time')->nullable()->after('return_location');
            $table->string('return_time')->nullable()->after('pickup_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('pickup_location');
            $table->dropColumn('return_location');
            $table->dropColumn('pickup_time');
            $table->dropColumn('return_time');
        });
    }
};
