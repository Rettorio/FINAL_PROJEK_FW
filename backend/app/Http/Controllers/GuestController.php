<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        return view('beranda');
    }

    public function profil()
    {
        return view('profil');
    }

    public function login()
    {
        return view('masuk');
    }

    public function livecount()
    {
        return view('livecount');
    }

    public function pemilih()
    {
        return view('daftarpemilih');
    }
}
