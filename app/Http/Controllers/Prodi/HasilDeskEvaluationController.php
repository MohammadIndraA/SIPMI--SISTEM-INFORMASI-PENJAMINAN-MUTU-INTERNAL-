<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\BuktiPendukung;
use App\Models\DaftarSubStandar;
use App\Models\DaftarTemuanAudit;
use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\KategoriDokumen;
use App\Models\StandarNasional;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class HasilDeskEvaluationController extends Controller
{
      public static function middleware()
    {
        return [
            new Middleware('permission:view-desk-evaluation', ['only' => ['index','show']]),
        ];
    }
    public function index(Request $request)
    {
        $lastSegment = collect(request()->segments())->last();
       $nameSegement = collect(request()->segments())->slice(-2, 1)->first();
        $kategori_dokumens = KategoriDokumen::all();
        $sub_standars = DaftarSubStandar::with([
                        'daftar_standar_mutu.tahun_periode',
                        'daftar_standar_mutu.lembaga_akreditasi',
                          'poins' => function ($query) use ($nameSegement) {
                                $query->whereHas('prodis', function ($q) use ($nameSegement) {
                                    $q->where('fakultas_prodis.slug', $nameSegement);
                                });
                            },
                            'poins.prodis'
                    ])->where('slug', $lastSegment)->firstOrFail();
       $tahun = $sub_standars->daftar_standar_mutu->tahun_periode;
       $lembaga = $sub_standars->daftar_standar_mutu->lembaga_akreditasi;
        $jawabans = Jawaban::with('user')->where('daftar_sub_standar_id', $sub_standars->id)->get()->keyBy('poin_id');
        $jawaban_auditor = DaftarTemuanAudit::where('prodi', $nameSegement)->where('daftar_sub_standar_id', $sub_standars->id)->get()->keyBy('poin_id');
        $file_pendukungs = BuktiPendukung::where('daftar_sub_standar_id', $sub_standars->id)->get()->groupBy('poin_id');
        // dd($file_pendukungs);
        return view('prodi.rekapDeskEvaluasi.index', compact('kategori_dokumens', 'sub_standars', 'jawabans', 'tahun', 'lembaga', 'file_pendukungs', 'jawaban_auditor'));
    }
}
