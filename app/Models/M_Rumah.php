<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_Rumah extends Model
{
    protected $table = 'tb_rumah';

    public static function index()
    {
        return DB::table('user')
                ->join('tb_rumah', 'user.kode_rumah', '=', 'tb_rumah.kode_rumah')
                ->select('user.nama', 'tb_rumah.no_rumah', 'tb_rumah.no_iot','tb_rumah.status')
                ->get();
    }
}
