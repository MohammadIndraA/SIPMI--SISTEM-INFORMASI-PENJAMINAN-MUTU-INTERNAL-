<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\DaftarSubStandar;
use App\Models\Jawaban;
use App\Models\KategoriDokumen;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class SubStandarController extends Controller
{
       public static function middleware()
    {
        return [
            new Middleware('permission:view-sub-standar', ['only' => ['index','show']]),
        ];
    }
      public function index(Request $request)
    {
        $lastSegment = collect(request()->segments())->last();
        $kategori_dokumens = KategoriDokumen::all();
        $roleName = Auth::user()->getRoleNames()->first();
        $sub_standars = DaftarSubStandar::with([
                        'daftar_standar_mutu.tahun_periode',
                        'daftar_standar_mutu.lembaga_akreditasi',
                          'poins' => function ($query) {
                                $query->whereHas('prodis', function ($q) {
                                    $q->where('fakultas_prodis.id', auth()->user()->fakultas_id);
                                });
                            },
                            'poins.prodis'
                    ])->where('slug', $lastSegment)->firstOrFail();
       $tahun = $sub_standars->daftar_standar_mutu->tahun_periode;
       $lembaga = $sub_standars->daftar_standar_mutu->lembaga_akreditasi;
        $jawabans = Jawaban::where('user_id', auth()->user()->id)->where('daftar_sub_standar_id', $sub_standars->id)->get()->keyBy('poin_id'); 
        return view('prodi.subStandar.index', compact('kategori_dokumens', 'sub_standars', 'jawabans', 'tahun', 'lembaga'));
    }
}
