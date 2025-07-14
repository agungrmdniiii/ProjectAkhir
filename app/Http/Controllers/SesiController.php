<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SesiController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function loginPage()
    {
        return view('Autentikasi/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == "admin") {
                return redirect('/danger');
            } elseif (Auth::user()->role == "user") {
                return redirect('/pemilik');
            } elseif (Auth::user()->role == "siskamling") {
                echo "role tidak ada";
            }
        } else {
            return redirect('/')->withErrors('Password Tidak Sesuai')->withInput();
        }
    }

    public function logout()
    {
        // dd(Auth::user());
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
          



        ], [
            
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
           
        ]);

        $user = User::create([
           
            'email' => $request->email,
            'password' => bcrypt($request->password),
          

            'role' => 'user' // Automatically set thole to 'warga'
        ]);

        return redirect('/');
        
        

        
    }
}
