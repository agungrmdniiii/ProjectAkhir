<?php

namespace App\Http\Controllers;

use App\Models\History;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Laporan; 
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use App\Models\Hama;
use Illuminate\Http\Request;
use App\Models\PengajuanHama;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Log;

class C_DangerZ extends Controller
{
    public function index()
    {
        return view('home.v_danger');
    }
    

    public function save() {
        // Ambil data status dari user dengan id 2
        $data = User::where('id', 2)->value('status');
    
        // Tambahkan nilai status dengan 1
        $nilai = $data + 1;
    
        // Update nilai status user dengan id 2
        User::where('id', 2)->update(['status' => $nilai]);
    
        // Ambil user id yang sedang aktif
        $activeUserId = Auth::id();
    
        // Buat data untuk History
        $historyData = [
            'user_id' => $activeUserId,
            'created_at' => Carbon::now(),
            // Tambahkan kolom lain yang diperlukan oleh model History
        ];
    
        // Insert data ke model History
        History::create($historyData);
    }
    
    public function history(){
       
        return view('home.historylaporan');
    }
    
    public function manageHama()
    {
        $hama = Hama::all();
        return view('home.v_keloladatahama', compact('hama'));
    }

    public function storeHama(Request $request)
    {
        $request->validate([
            'nama_hama' => 'required',
            'icon' => 'required',
            'min_humidity' => 'required|numeric',
            'max_humidity' => 'required|numeric',
            'min_temperature' => 'required|numeric',
            'max_temperature' => 'required|numeric',
            'rekomendasi' => 'required'
        ]);

        // Konversi rekomendasi dari textarea menjadi array JSON
        $rekomendasi = array_filter(explode("\n", $request->rekomendasi));
        $rekomendasi = array_map('trim', $rekomendasi);

        Hama::create([
            'nama_hama' => $request->nama_hama,
            'icon' => $request->icon,
            'min_humidity' => $request->min_humidity,
            'max_humidity' => $request->max_humidity,
            'min_temperature' => $request->min_temperature,
            'max_temperature' => $request->max_temperature,
            'rekomendasi' => json_encode($rekomendasi)
        ]);

        return redirect()->back()->with('success', 'Data hama berhasil ditambahkan');
    }

    public function updateHama(Request $request, $id)
    {
        $request->validate([
            'nama_hama' => 'required',
            'icon' => 'required',
            'min_humidity' => 'required|numeric',
            'max_humidity' => 'required|numeric',
            'min_temperature' => 'required|numeric',
            'max_temperature' => 'required|numeric',
            'rekomendasi' => 'required'
        ]);

        try {
            // Konversi rekomendasi dari textarea menjadi array
            $rekomendasi = array_filter(explode("\n", $request->rekomendasi));
            $rekomendasi = array_map('trim', $rekomendasi);
            
            $hama = Hama::findOrFail($id);
            $hama->update([
                'nama_hama' => $request->nama_hama,
                'icon' => $request->icon,
                'min_humidity' => $request->min_humidity,
                'max_humidity' => $request->max_humidity,
                'min_temperature' => $request->min_temperature,
                'max_temperature' => $request->max_temperature,
                'rekomendasi' => json_encode($rekomendasi)
            ]);

            return redirect()->back()->with('success', 'Data hama berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteHama($id)
    {
        $hama = Hama::findOrFail($id);
        $hama->delete();
        return redirect()->back()->with('success', 'Data hama berhasil dihapus');
    }

    public function getHamaData($id = null)
    {
        if ($id) {
            $hama = Hama::findOrFail($id);
            return response()->json($hama);
        }
        return response()->json(Hama::all());
    }

    public function getPersebaranHama()
    {
        try {
            $data = PengajuanHama::with('hama')
                ->whereNotNull(['koordinat_lat', 'koordinat_lon'])
                ->orderBy('waktu_pelaporan', 'desc')
                ->get();
            
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveWeatherData(Request $request)
    {
        $date = Carbon::today();
        
        // Cek apakah data untuk hari ini dan lokasi ini sudah ada
        $existingData = WeatherData::where('date', $date)
            ->where('latitude', $request->latitude)
            ->where('longitude', $request->longitude)
            ->first();
        
        if ($existingData) {
            // Update data yang ada
            $existingData->update([
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'rainfall' => $request->rainfall ?? 0,
                'solar_radiation' => $request->solar_radiation ?? 0,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        } else {
            // Buat data baru
            WeatherData::create([
                'date' => $date,
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'rainfall' => $request->rainfall ?? 0,
                'solar_radiation' => $request->solar_radiation ?? 0,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        }
        
        return response()->json(['success' => true]);
    }

    public function getWeatherData(Request $request)
    {
        $period = $request->input('period', 'week');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        $query = WeatherData::query();
        
        // Filter berdasarkan lokasi jika ada
        if ($latitude && $longitude) {
            $query->byLocation($latitude, $longitude);
        }
        
        // Filter berdasarkan periode
        if ($period === 'week') {
            $startDate = Carbon::now()->subDays(7);
            $endDate = Carbon::now();
            $query->inDateRange($startDate, $endDate);
        } else {
            // Filter untuk hari tertentu
            $dayOfWeek = Carbon::parse($period)->dayOfWeek;
            $query->whereRaw('DAYOFWEEK(date) = ?', [$dayOfWeek]);
        }
        
        $data = $query->orderBy('date', 'asc')->get();
        return response()->json($data);
    }
}
