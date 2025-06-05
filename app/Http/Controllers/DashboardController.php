<?php

namespace App\Http\Controllers;

use App\Models\DaftarStandarMutu;
use App\Models\FakultasProdi;
use App\Models\LembagaAkreditasi;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;

class DashboardController extends Controller
{
    public function index()
    {
       $fakultas_prodis = FakultasProdi::all()->count(); 
       $lembaga_akreditasi = LembagaAkreditasi::all()->count();
       $daftar_standar_mutu = DaftarStandarMutu::all()->count();
       return view('dashboard.index', compact('fakultas_prodis', 'lembaga_akreditasi', 'daftar_standar_mutu'));
    }
}
