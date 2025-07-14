<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanHama;
use Carbon\Carbon;

class HamaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'jenis_hama' => 'Tikus',
                'lokasi' => 'Lahan Sawah Blok A',
                'keterangan' => 'Ditemukan beberapa tikus di area persawahan',
                'waktu_pelaporan' => Carbon::now()->subDays(2),
                'suhu' => 28.5,
                'kelembaban' => 75.0,
                'koordinat_lat' => -6.9175,
                'koordinat_lon' => 107.6191,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ],
            [
                'jenis_hama' => 'Wereng',
                'lokasi' => 'Lahan Sawah Blok B',
                'keterangan' => 'Serangan wereng di beberapa tanaman padi',
                'waktu_pelaporan' => Carbon::now()->subDay(),
                'suhu' => 29.0,
                'kelembaban' => 80.0,
                'koordinat_lat' => -6.9180,
                'koordinat_lon' => 107.6200,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay()
            ],
            [
                'jenis_hama' => 'Ulat',
                'lokasi' => 'Lahan Sawah Blok C',
                'keterangan' => 'Banyak ulat ditemukan di daun padi',
                'waktu_pelaporan' => Carbon::now(),
                'suhu' => 27.5,
                'kelembaban' => 85.0,
                'koordinat_lat' => -6.9190,
                'koordinat_lon' => 107.6210,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($data as $item) {
            PengajuanHama::create($item);
        }
    }
}