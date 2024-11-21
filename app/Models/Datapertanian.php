<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapertanian extends Model
{
    use HasFactory;

    // Nama tabel yang akan digunakan
    protected $table = 'data_pertanian';  

    // Field yang bisa diisi
    protected $fillable = [
        'jumlah_pestisida',
        'lama_panen',
        'hasil_panen',
        'luas_lahan',
    ];
}