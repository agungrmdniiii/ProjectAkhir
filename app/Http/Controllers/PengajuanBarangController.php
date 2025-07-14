<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarang;
use App\Models\PersediaanBarang;
use Illuminate\Http\Request;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        $pengajuanBarang = PengajuanBarang::all();
        return view('barang.index', compact('pengajuanBarang'));
    }

    public function create()
    {
        $persediaanBarang = PersediaanBarang::all();
        return view('barang.create', compact('persediaanBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'keterangan' => 'nullable',
        ]);

        PengajuanBarang::create($request->all());

        return redirect()->route('pengajuanbarang.index')->with('success', 'Pengajuan barang berhasil ditambahkan');
    }

    public function setujui(PengajuanBarang $pengajuanBarang)
    {
        $persediaanBarang = PersediaanBarang::where('nama_barang', $pengajuanBarang->nama_barang)->first();
        
        if ($persediaanBarang && $persediaanBarang->stok >= $pengajuanBarang->jumlah) {
            // Kurangi stok
            $persediaanBarang->stok -= $pengajuanBarang->jumlah;
            $persediaanBarang->save();
            
            // Hapus pengajuan
            $pengajuanBarang->delete();
            
            return redirect()->route('pengajuanbarang.index')
                ->with('success', 'Pengajuan barang berhasil disetujui dan stok dikurangi');
        }
        
        return redirect()->route('pengajuanbarang.index')
            ->with('error', 'Stok tidak mencukupi');
    }

    public function destroy(PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->delete();

        return redirect()->route('pengajuanbarang.index')->with('success', 'Pengajuan barang berhasil dihapus');
    }

    public function edit($id)
    {
        $persediaanBarang = PersediaanBarang::all();
        return view('barang.edit', compact('persediaanBarang'));
    }

    public function update(Request $request, $id)
    {
        $persediaanBarang = PersediaanBarang::findOrFail($id);
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $persediaanBarang->update([
            'stok' => $request->stok
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diperbarui');
    }

    public function editPersediaan()
    {
        $persediaanBarang = PersediaanBarang::all();
        return view('barang.edit', compact('persediaanBarang'));
    }

    public function storePersediaan(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:persediaan_barang',
            'stok' => 'required|integer|min:0'
        ]);

        PersediaanBarang::create($request->all());
        return redirect()->route('persediaan.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function updatePersediaan(Request $request, $id)
    {
        $persediaanBarang = PersediaanBarang::findOrFail($id);
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $persediaanBarang->update([
            'stok' => $request->stok
        ]);

        return redirect()->route('persediaan.index')->with('success', 'Stok berhasil diperbarui');
    }
}
