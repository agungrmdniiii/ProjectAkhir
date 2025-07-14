<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rumah;
use App\Models\Ronda;
use App\Models\User;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        return view('Pemilik.homepemilik')->with('data',$data);
    }
    public function dangerpemilik()
    {
        $data = User::all();
        return view('Pemilik.dangerpemilik')->with('data',$data);
    }
    public function jadwalronda()
    {
        $data = Ronda::all();
        return view('Pemilik.jadwalronda')->with('data',$data);
    }
    public function laporan()
    {
        
        return view('Pemilik.laporan');
    }
    public function prediksiHama()
    {
        $data = User::all();
        return view('Pemilik.prediksi_hama')->with('data', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
