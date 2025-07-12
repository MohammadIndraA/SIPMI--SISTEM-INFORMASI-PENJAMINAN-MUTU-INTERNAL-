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
       $fakultas_prodis = FakultasProdi::count(); 
       $lembaga_akreditasi = LembagaAkreditasi::count();
       $daftar_standar_mutu = DaftarStandarMutu::count();
       $poin_desk_evaluation = Poin::count() * $fakultas_prodis;
       $tidak_masuk_desk_centang = Poin::count() * $fakultas_prodis - DB::table('poin_prodi')->count(); //yang tidak di centang
       $tidak_masuk_desk = Poin::count() - DB::table('poin_prodi')->distinct()->count('poin_id');
      $get_desk_evaluation_prodi = [];

      $get_desk_evaluation_prodi = DB::table('poin_prodi')
         ->join('fakultas_prodis', 'fakultas_prodis.id', '=', 'poin_prodi.fakultas_prodi_id')
         ->join('users', 'users.fakultas_id', '=', 'fakultas_prodis.id')
         ->join('jawabans', 'jawabans.user_id', '=', 'users.id')
         ->select(
            'fakultas_prodis.id as fakultas_prodi_id',
            'fakultas_prodis.fakultas_prodi',
            'fakultas_prodis.slug as fakultas_slug',
            DB::raw('COUNT(DISTINCT poin_prodi.id) as total_prodi'),
            DB::raw('COUNT(DISTINCT jawabans.id) as total_jawaban')
         )
         ->groupBy('fakultas_prodis.id', 'fakultas_prodis.fakultas_prodi')
         ->get();

    //    auditor
      $hasil_desk_evaluation = DaftarTemuanAudit::count();
      $hasil_visitasi = DaftarTemuan::count();
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

       return view('dashboard.index', compact('fakultas_prodis', 'lembaga_akreditasi', 'daftar_standar_mutu', 'belum_desk_evaluation', 'sudah_desk_evaluation', 'belum_visitasi', 'sudah_visitasi', 'prodi_sudah_desk_evaluation', 'prodi_belum_desk_evaluation', 'poin_desk_evaluation','tidak_masuk_desk','prodi_jumlah_desk_evaluation', 'get_desk_evaluation_prodi'));
    }
}
