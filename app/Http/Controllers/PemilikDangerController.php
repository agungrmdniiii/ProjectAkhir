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

class PemilikDangerController extends Controller
{
    public function index()
    {
        return view('Pemilik.v_danger');
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
        ];
    
        // Insert data ke model History
        History::create($historyData);
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
        $data = PengajuanHama::select('jenis_hama', 'lokasi', 'waktu_pelaporan', 'suhu', 'kelembaban', 'keterangan', 'koordinat_lat', 'koordinat_lon')
            ->whereNotNull(['koordinat_lat', 'koordinat_lon'])
            ->get();
        
        return response()->json($data);
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