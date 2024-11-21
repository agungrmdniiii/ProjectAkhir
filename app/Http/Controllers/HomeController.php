<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller

{
    
    public $data;
public function __construct()
     {
         $this->data = User::all();
     }

    public function index()
    {
        return view('home.home',['data' => $this->data]);
        
    }
}
?>