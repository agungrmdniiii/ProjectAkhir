<?php

namespace App\Http\Controllers;

use App\Models\History;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Laporan; 
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;

class Monitoringhama extends Controller
{
    public function index(){
        $data=user::all();
        return view('pemilik.monitoringhama',['data' => $data]
    );
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
    
}
