<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pemilihan()
    {
        return view('pemilihan');
    }

    public function logout()
    {
        return view('keluar');
    }
}
