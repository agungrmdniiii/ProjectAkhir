<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarang;
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
        return view('barang.create');
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

    public function edit(PengajuanBarang $pengajuanBarang)
    {
        return view('barang.edit', compact('pengajuanBarang'));
    }

    public function update(Request $request, PengajuanBarang $pengajuanBarang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer',
            'keterangan' => 'nullable',
        ]);

        $pengajuanBarang->update($request->all());

        return redirect()->route('pengajuanbarang.index')->with('success', 'Pengajuan barang berhasil diperbarui');
    }

    public function destroy(PengajuanBarang $pengajuanBarang)
    {
        $pengajuanBarang->delete();

        return redirect()->route('pengajuanbarang.index')->with('success', 'Pengajuan barang berhasil dihapus');
    }
}
