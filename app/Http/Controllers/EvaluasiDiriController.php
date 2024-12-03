<?php

namespace App\Http\Controllers;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class EvaluasiDiriController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-evaluasi-diri', ['only' => ['index','show']]),
        ];
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = DB::table('fakultas_prodis')
            ->leftJoin('target_nilai_mutus', 'fakultas_prodis.id', '=', 'target_nilai_mutus.fakultas_prodi_id')
            ->leftJoin('evaluasi_diris', 'fakultas_prodis.id', '=', 'evaluasi_diris.fakultas_prodi_id')
            ->select('fakultas_prodis.*', 'target_nilai_mutus.target_nilai_mutu', 'evaluasi_diris.nilai_evaluasi', 'evaluasi_diris.sudah_menjawab', 'evaluasi_diris.belum_menjawab')
                ->when($request->filled('tahun_periode_id'), function ($query) use ($request) {
                $query->where('tahun_periode_id', $request->tahun_periode_id);
            })
            ->when($request->filled('lembaga_akreditasi_id'), function ($query) use ($request) {
                $query->where('lembaga_akreditasi_id', $request->lembaga_akreditasi_id);
            });        
            return datatables($query)
                ->addIndexColumn()
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('evaluasiDiri.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }
}
