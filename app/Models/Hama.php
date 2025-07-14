<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hama extends Model
{
    use HasFactory;
    
    protected $table = 'hama';
    protected $fillable = [
        'nama_hama',
        'icon',
        'min_humidity',
        'max_humidity',
        'min_temperature',
        'max_temperature',
        'rekomendasi'
    ];
}