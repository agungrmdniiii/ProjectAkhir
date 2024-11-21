<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['created_at'];
    protected $table ='history';

    public static function getData()
    {
        return self::all();
    }
    
}
