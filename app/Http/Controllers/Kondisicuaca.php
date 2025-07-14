<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kondisicuaca extends Controller
{
    public function kondisicuaca()
    {
        return view('home.kondisicuaca');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'rainfall' => 'required|numeric',
            'solar_radiation' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        WeatherData::updateOrCreate(
            [
                'date' => Carbon::today('Asia/Jakarta'),
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude']
            ],
            $data
        );

        return response()->json(['message' => 'Data cuaca terkini berhasil diperbarui'], 200);
    }

    public function getAvailableDates()
    {
        $dates = WeatherData::query()
            ->select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');

        return response()->json($dates);
    }

    public function getData(Request $request)
    {
        $validated = $request->validate([
            'period' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $period = $validated['period'];
        $lat = $validated['latitude'];
        $lon = $validated['longitude'];
        $tz = 'Asia/Jakarta';
    
        Log::info('Request masuk ke getData', compact('period', 'lat', 'lon'));
    
        $response = [
            'labels' => [],
            'datasets' => [
                'temperature' => [], 'humidity' => [], 'rainfall' => [], 'solar_radiation' => [],
            ],
            'x_axis_label' => 'Tanggal'
        ];
    
        try {
            $carbonDate = Carbon::parse($period);
            $dateToQuery = $carbonDate->toDateString();
            $isSpecificDate = true;
        } catch (\Exception $e) {
            $isSpecificDate = false;
        }
        
        if ($isSpecificDate) {
            
            $dateToQuery = Carbon::parse($period)->toDateString();
            Log::info('Query data untuk tanggal spesifik', ['date' => $dateToQuery]);

            $dayData = WeatherData::query()
                ->where('date', $dateToQuery)
                ->whereBetween('latitude', [$lat - 0.01, $lat + 0.01])
                ->whereBetween('longitude', [$lon - 0.01, $lon + 0.01])
                ->first();
    
            if ($dayData) {
                Log::info('Data ditemukan untuk tanggal spesifik', ['data' => $dayData]);
            } else {
                Log::warning('Data tidak ditemukan untuk tanggal spesifik', ['date' => $dateToQuery]);
            }
    
            $response['labels'] = ['Suhu', 'Kelembaban', 'Curah Hujan', 'Radiasi Matahari'];
            $response['datasets']['temperature'] = [$dayData->temperature ?? 0];
            $response['datasets']['humidity'] = [$dayData->humidity ?? 0];
            $response['datasets']['rainfall'] = [$dayData->rainfall ?? 0];
            $response['datasets']['solar_radiation'] = [$dayData->solar_radiation ?? 0];
            $response['x_axis_label'] = 'Jenis Data Cuaca';
    
        } elseif ($period === 'daily') {
            $dateToQuery = Carbon::now($tz);
            Log::info('Query data untuk harian', ['date' => $dateToQuery->toDateString()]);
    
            $dayData = WeatherData::query()
                ->where('date', $dateToQuery->toDateString())
                ->whereBetween('latitude', [$lat - 0.01, $lat + 0.01])
                ->whereBetween('longitude', [$lon - 0.01, $lon + 0.01])->latest('date')
                ->first();
    
            if ($dayData) {
                Log::info('Data ditemukan untuk harian', ['data' => $dayData]);
            } else {
                Log::warning('Data tidak ditemukan untuk harian');
            }
    
            $response['labels'][] = $dateToQuery->format('d M Y');
            $response['datasets']['temperature'][] = $dayData->temperature ?? 0;
            $response['datasets']['humidity'][] = $dayData->humidity ?? 0;
            $response['datasets']['rainfall'][] = $dayData->rainfall ?? 0;
            $response['datasets']['solar_radiation'][] = $dayData->solar_radiation ?? 0;
            $response['x_axis_label'] = 'Data Hari Ini';
    
        } elseif ($period === 'monthly') {
            Log::info('Query data untuk periode bulanan');
        
            $startDate = Carbon::now($tz)->subDays(29)->startOfDay(); // 30 hari termasuk hari ini
            $endDate = Carbon::now($tz)->endOfDay();
        
            $data = WeatherData::query()
                ->whereBetween('latitude', [$lat - 0.01, $lat + 0.01])
                ->whereBetween('longitude', [$lon - 0.01, $lon + 0.01])
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                });
        
            for ($i = 0; $i < 30; $i++) {
                $currentDate = $startDate->copy()->addDays($i);
                $dateKey = $currentDate->format('Y-m-d');
                $dayData = $data->get($dateKey)?->last(); // Ambil data terakhir jika lebih dari satu di hari yang sama
        
                Log::info('Data bulan ditemukan', ['date' => $dateKey]);
        
                $response['labels'][] = $currentDate->format('d M');
                $response['datasets']['temperature'][] = $dayData->temperature ?? 0;
                $response['datasets']['humidity'][] = $dayData->humidity ?? 0;
                $response['datasets']['rainfall'][] = $dayData->rainfall ?? 0;
                $response['datasets']['solar_radiation'][] = $dayData->solar_radiation ?? 0;
            }
        
            $response['x_axis_label'] = 'Tanggal dalam 30 Hari Terakhir';
        } else {
            $days = ($period === 'weekly') ? 7 : 30;
            $startDate = Carbon::now($tz)->subDays($days - 1)->startOfDay();
            $endDate = Carbon::now($tz)->endOfDay();
    
            Log::info('Query data untuk periode: ' . $period, ['start' => $startDate, 'end' => $endDate]);
    
            $data = WeatherData::query()
                ->whereBetween('latitude', [$lat - 0.01, $lat + 0.01])
                ->whereBetween('longitude', [$lon - 0.01, $lon + 0.01])
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'asc')
                ->get()
                ->keyBy(fn($item) => Carbon::parse($item->date)->toDateString());
    
            for ($i = 0; $i < $days; $i++) {
                $currentDate = $startDate->copy()->addDays($i);
                $dateKey = $currentDate->toDateString();
    
                $response['labels'][] = $currentDate->format('d M');
                $dayData = $data->get($dateKey);
    
                if ($dayData) {
                    Log::info('Data ditemukan untuk tanggal', ['date' => $dateKey]);
                }
    
                $response['datasets']['temperature'][] = $dayData->temperature ?? 0;
                $response['datasets']['humidity'][] = $dayData->humidity ?? 0;
                $response['datasets']['rainfall'][] = $dayData->rainfall ?? 0;
                $response['datasets']['solar_radiation'][] = $dayData->solar_radiation ?? 0;
            }
        }
    
        return response()->json($response);
    }
    
    
    
}
