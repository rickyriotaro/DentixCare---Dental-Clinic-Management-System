<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // contoh data statik (kamu bisa ganti query sesuai tabelmu)
        $selesai = 5;
        $ditangani = 1;
        $antrian = 3;

        return view('dashboard', compact('selesai','ditangani','antrian'));
    }
}
