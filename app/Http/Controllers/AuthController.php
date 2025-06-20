<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $supabaseUrl;
    private $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_KEY');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'apikey' => $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/token?grant_type=password", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('supabase_token', $data['access_token']);
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Email atau password salah');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'apikey' => $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->supabaseUrl}/auth/v1/signup", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Berhasil daftar! Silakan login.');
        } else {
            return back()->with('error', 'Gagal register: ' . $response->body());
        }
    }

    public function logout(Request $request)
    {
        Session::forget('supabase_token');
        return redirect()->route('login');
    }
}
// This controller handles user authentication using Supabase.
// It includes methods for showing the login and registration forms, handling login and registration requests, and logging out users.