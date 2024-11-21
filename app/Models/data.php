<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;
    protected $fillable = ['Nama_pemilik_rumah','No_rumah','No_IoT','status'];
    protected $table ='rumahs';
    
    public static function getData()
    {
        return self::all();
    }
}
