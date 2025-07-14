<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanHama extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_hama';

    protected $fillable = [
        'jenis_hama',
        'lokasi',
        'keterangan',
        'waktu_pelaporan',
        'suhu',
        'kelembaban',
        'koordinat_lat',
        'koordinat_lon'
    ];

    // Hapus relasi dengan model Hama karena sekarang menyimpan nama langsung
    // public function hama()
    // {
    //     return $this->belongsTo(Hama::class, 'jenis_hama', 'id');
    // }
}