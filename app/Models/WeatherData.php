<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $fillable = [
        'date',
        'temperature',
        'humidity',
        'rainfall',
        'solar_radiation',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'date' => 'date',
        'temperature' => 'float',
        'humidity' => 'float',
        'rainfall' => 'float',
        'solar_radiation' => 'float',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    // Menambahkan scope untuk mengambil data berdasarkan lokasi
    public function scopeByLocation($query, $latitude, $longitude)
    {
        return $query->where('latitude', $latitude)
                    ->where('longitude', $longitude);
    }

    // Menambahkan scope untuk mengambil data dalam rentang waktu
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}