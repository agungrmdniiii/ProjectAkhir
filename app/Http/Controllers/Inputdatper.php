<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datapertanian;

class Inputdatper extends Controller
{
    

    public function index()
    {
        return view('pemilik.upldatapertanian');
        
    }


    
        /**
         * Store data pertanian ke dalam database.
         */
        public function store(Request $request)
        {
            // Validasi input dari form
            $request->validate([
                'jumlah_pestisida' => 'required|numeric',
                'lama_panen' => 'required|numeric',
                'hasil_panen' => 'required|numeric',
                'luas_lahan' => 'required|numeric',
            ]);
    
            // Simpan data ke database
            DataPertanian::create([
                'jumlah_pestisida' => $request->jumlah_pestisida,
                'lama_panen' => $request->lama_panen,
                'hasil_panen' => $request->hasil_panen,
                'luas_lahan' => $request->luas_lahan,
            ]);
    
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Data pertanian berhasil disimpan.');
        }
 // Menampilkan data hasil input di dalam tabel
 public function show()
 {
     // Mengambil semua data dari tabel 'data_pertanian'
     $dataPertanian = Datapertanian::all();

     // Menampilkan view dengan data yang diambil
     return view('home.tampilpertanian', compact('dataPertanian'));
 }

 // Menampilkan halaman edit untuk data tertentu
 public function edit($id)
 {
     // Mengambil data berdasarkan ID
     $dataPertanian = Datapertanian::findOrFail($id);

     // Menampilkan view edit dengan data yang diambil
     return view('home.editpertanian', compact('dataPertanian'));
 }

 // Memperbarui data yang sudah diubah
 public function update(Request $request, $id)
 {
     // Validasi input dari form
     $request->validate([
         'jumlah_pestisida' => 'required|numeric',
         'lama_panen' => 'required|numeric',
         'hasil_panen' => 'required|numeric',
         'luas_lahan' => 'required|numeric',
     ]);

     // Mengambil data berdasarkan ID dan mengupdate-nya
     $dataPertanian = Datapertanian::findOrFail($id);
     $dataPertanian->update($request->all());

     // Redirect ke halaman daftar data dengan pesan sukses
     return redirect()->route('data.show')->with('success', 'Data pertanian berhasil diperbarui.');
 }

 // Menghapus data berdasarkan ID
 public function destroy($id)
 {
     // Mengambil data berdasarkan ID dan menghapusnya
     $dataPertanian = Datapertanian::findOrFail($id);
     $dataPertanian->delete();

     // Redirect ke halaman daftar data dengan pesan sukses
     return redirect()->route('data.show')->with('success', 'Data pertanian berhasil dihapus.');
 }
 public function hasilPertanian() {
    // Ambil semua data dari model Datapertanian
    $dataPertanian = Datapertanian::all();
    
    // Kirim data ke view hasilpertanian yang berada di folder home
    return view('Pemilik.hasilpertanian', compact('dataPertanian'));
}
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('home.create_ronda');
    // }

   
    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     $data = Ronda::findOrFail($id);
    //     return view('home.edit_ronda', compact('data'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'hari' => 'required',
    //         'waktu' => 'required:ronda,waktu'.$id,
    //         'petugas' => 'required:ronda,petugas'.$id
           
    //     ]);
    
    //     $data = Ronda::findOrFail($id);
    //     $data->hari = $request->input('hari');
    //     $data->waktu= $request->input('waktu');
    //     $data->petugas = $request->input('petugas');
    //     $data->save();
    
    //     return redirect('ronda')->with('success','Data updated successfully');
    // }
    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(int $id)
    // {
    //     $data = Ronda::findOrFail($id);
    //     $data->delete();
    
    //     return redirect('ronda')->with('success','Data deleted successfully');
    // }


}
