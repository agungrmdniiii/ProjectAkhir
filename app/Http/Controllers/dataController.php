<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data;
use App\Models\User;

class dataController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public $data;

     public function __construct()
     {
         $this->data = User::all();
     }

    public function index()
    {
        return view('data.index',['data' => $this->data]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nomor_rumah' => 'required',
            'nomor_perangkat' => 'required'
        ]);
        User::insert($request->except('_token'));
        return redirect()->route('data.index');
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
        $data = User::findOrFail($id);
        return view('data.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'nomor_rumah' => 'required',
            'nomor_perangkat' => 'required'
        ]);
    
        $data = User::findOrFail($id);
        $data->name = $request->input('name');
        $data->nomor_rumah = $request->input('nomor_rumah');
        $data->nomor_perangkat = $request->input('nomor_perangkat');
        $data->save();
    
        return redirect()->route('data.index')->with('success','Data updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    
        return redirect()->route('data.index')->with('success','Data deleted successfully');
    }
}
