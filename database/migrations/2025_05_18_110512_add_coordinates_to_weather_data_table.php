<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('weather_data', function (Blueprint $table) {
        $table->decimal('latitude', 10, 8)->after('solar_radiation');
        $table->decimal('longitude', 11, 8)->after('latitude');
        
        // Menambahkan unique constraint untuk mencegah duplikasi data
        $table->unique(['date', 'latitude', 'longitude']);
    });
}

public function down()
{
    Schema::table('weather_data', function (Blueprint $table) {
        $table->dropColumn(['latitude', 'longitude']);
        $table->dropUnique(['date', 'latitude', 'longitude']);
    });
}
};
