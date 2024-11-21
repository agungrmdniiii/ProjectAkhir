<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
        public $table = 'user';
    
        public static function getData()
        {
            return self::all();
        }

}
