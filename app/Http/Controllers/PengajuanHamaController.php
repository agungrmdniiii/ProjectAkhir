<?php

namespace App\Http\Controllers;

use App\Models\PengajuanHama;
use App\Models\Hama;
use Illuminate\Http\Request;

class PengajuanHamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanHama = PengajuanHama::latest()->get();
        return view('hama.index', compact('pengajuanHama'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hamaList = Hama::all();
        return view('hama.create', compact('hamaList'));
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

        return redirect()->route('pengajuanhama.index')
            ->with('success', 'Pengajuan hama berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengajuanHama = PengajuanHama::findOrFail($id);
        $pengajuanHama->delete();
        
        return redirect()->route('pengajuanhama.index')
            ->with('success', 'Pengajuan hama berhasil dihapus');
    }

    public function getPersebaranHama()
    {
        try {
            $pengajuanHama = PengajuanHama::whereNotNull('koordinat_lat')
                ->whereNotNull('koordinat_lon')
                ->orderBy('waktu_pelaporan', 'desc')
                ->get();
            
            return response()->json($pengajuanHama);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
