<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data['title'] = "Dashboard";
        return view('admin.dashboard', $data);   
    }

    public function datakandidat()
    {
        return view('kandidat');
    }

    public function datamasyarakat()
    {
        return view('masyarakat');
    }

    public function credentialgenerator()
    {
        return view('kredensial');
    }   

    public function credentialgeneratorStore()
    {
        // return view('kredensial');
        return redirect()->back();
    }

    public function lihathasil()
    {
        return view('hasil');
    }   
}