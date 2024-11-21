<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;

class userss extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data = users::all();
    }

    public function index()
    {
        return view('home.v_editdata', ['data' => $this->data]);
    }

    public function create(){
        return view('create');
    }
}
