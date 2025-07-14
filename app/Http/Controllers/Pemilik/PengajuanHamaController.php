<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\PengajuanHama;
use App\Models\Hama;
use Illuminate\Http\Request;

class PengajuanHamaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hamaList = Hama::all();
        return view('Pemilik.hama.create', compact('hamaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_hama' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'nullable',
            'suhu' => 'required|numeric',
            'kelembaban' => 'required|numeric',
            'koordinat_lat' => 'required|numeric',
            'koordinat_lon' => 'required|numeric',
            // Validasi untuk hama baru
            'nama_hama_baru' => 'required_if:jenis_hama,other'
        ], [
            'lokasi.required' => 'Lokasi harus ditentukan menggunakan deteksi otomatis atau pilih di peta',
            'koordinat_lat.required' => 'Koordinat lokasi harus ditentukan',
            'koordinat_lon.required' => 'Koordinat lokasi harus ditentukan'
        ]);

        $data = $request->all();
        $data['waktu_pelaporan'] = now();

        // Jika user memilih "Jenis Hama Lain"
        if ($request->jenis_hama === 'other') {
            $data['jenis_hama'] = $request->nama_hama_baru;
        } else {
            // Ambil data hama yang dipilih
            $hama = Hama::findOrFail($request->jenis_hama);
            $data['jenis_hama'] = $hama->nama_hama;
        }

        PengajuanHama::create($data);

        return redirect()->back()->with('success', 'Pengajuan hama berhasil ditambahkan');
    }
} 