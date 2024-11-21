<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ronda extends Model
{
    use HasFactory;
    protected $fillable = ['hari','waktu','petugas'];
    protected $table ='Ronda';
    
    public static function getData()
    {
        return self::all();
    }
}
