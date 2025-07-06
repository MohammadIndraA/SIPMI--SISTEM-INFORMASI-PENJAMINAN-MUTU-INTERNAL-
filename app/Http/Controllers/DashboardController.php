<?php

namespace App\Http\Controllers;

use App\Models\DaftarStandarMutu;
use App\Models\DaftarTemuan;
use App\Models\DaftarTemuanAudit;
use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\LembagaAkreditasi;
use App\Models\Poin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;

class DashboardController extends Controller
{
    public function index()
    {
    //    admin
       $fakultas_prodis = FakultasProdi::all()->count(); 
       $lembaga_akreditasi = LembagaAkreditasi::all()->count();
       $daftar_standar_mutu = DaftarStandarMutu::all()->count();
       $poin_desk_evaluation = Poin::all()->count() * $fakultas_prodis;
       $tidak_masuk_desk_centang = Poin::all()->count() * $fakultas_prodis - DB::table('poin_prodi')->count(); //yang tidak di centang
       $tidak_masuk_desk = Poin::all()->count() - DB::table('poin_prodi')->distinct()->count('poin_id');
       
    //    auditor
    $hasil_desk_evaluation = DaftarTemuanAudit::all()->count();
    $hasil_visitasi = DaftarTemuan::all()->count();
    $sudah_desk_evaluation = $hasil_desk_evaluation;
    $belum_desk_evaluation = $poin_desk_evaluation -$tidak_masuk_desk_centang - $hasil_desk_evaluation;
    $sudah_visitasi = $hasil_visitasi;
    $belum_visitasi = $poin_desk_evaluation - $tidak_masuk_desk_centang - $hasil_visitasi;

    // prodi
    $idProdi = auth()->user()->fakultas_id;
    $prodi_hasil_sudah_desk_evaluation = DB::table('poin_prodi')->where('fakultas_prodi_id', $idProdi)->get();

    $prodi_sudah_desk_evaluation = Jawaban::where('user_id', auth()->user()->id)->whereIn('poin_id', $prodi_hasil_sudah_desk_evaluation->pluck('poin_id'))->count();
    $prodi_belum_desk_evaluation = $prodi_hasil_sudah_desk_evaluation->count() - $prodi_sudah_desk_evaluation;
    $prodi_jumlah_desk_evaluation = DB::table('poin_prodi')->where('fakultas_prodi_id', $idProdi)->count();
    // tidak masuk desk

       return view('dashboard.index', compact('fakultas_prodis', 'lembaga_akreditasi', 'daftar_standar_mutu', 'belum_desk_evaluation', 'sudah_desk_evaluation', 'belum_visitasi', 'sudah_visitasi', 'prodi_sudah_desk_evaluation', 'prodi_belum_desk_evaluation', 'poin_desk_evaluation','tidak_masuk_desk','prodi_jumlah_desk_evaluation'));
    }
}
