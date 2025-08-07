<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
public function showLoginForm()
{
    return view('login-admin'); 
}


    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasAnyRole(['Panitia'])) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Akses hanya untuk admin');
            }
        }

        return redirect()->route('admin.login')->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
