<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        // sementara dummy (nanti bisa hitung dari database)
        $jumlahSelesai = 5;
        $jumlahProses  = 1;
        $noAntrian     = 3;

        return view('dokter.dashboard', compact('jumlahSelesai','jumlahProses','noAntrian'));
    }
}
