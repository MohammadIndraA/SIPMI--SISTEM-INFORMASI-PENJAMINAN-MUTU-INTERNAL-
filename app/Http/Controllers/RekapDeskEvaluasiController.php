<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiDiri;
use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\LembagaAkreditasi;
use App\Models\RekapDeskEvaluasi;
use App\Models\TahunPeriode;
use App\Models\TargetNilaiMutu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;

class RekapDeskEvaluasiController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-rekap-desk-evaluasi', ['only' => ['index','show']]),
            new Middleware('permission:create-rekap-desk-evaluasi', ['only' => ['create','store']]),
            new Middleware('permission:edit-rekap-desk-evaluasi', ['only' => ['edit','update']]),
            new Middleware('permission:delete-rekap-desk-evaluasi', ['only' => ['destroy']]),
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
             $query = DB::table('fakultas_prodis')
            ->Join('target_nilai_mutus', 'fakultas_prodis.id', '=', 'target_nilai_mutus.fakultas_prodi_id')
            ->select('fakultas_prodis.*', 'target_nilai_mutus.target_nilai_mutu','target_nilai_mutus.tahun_periode_id', 'target_nilai_mutus.lembaga_akreditasi_id')
            ->when($request->filled('tahun_periode_id'), function ($query) use ($request) {
                $query->where('target_nilai_mutus.tahun_periode_id', $request->tahun_periode_id );
            })
            ->when($request->filled('lembaga_akreditasi_id'), function ($query) use ($request) {
                $query->where('target_nilai_mutus.lembaga_akreditasi_id', $request->lembaga_akreditasi_id);
            });              
            return datatables($query)
                ->addIndexColumn()
                ->addColumn('desk_evaluasi', function ($row) {
                    return $this->getNilaiDeskEvaluasi($row->id, $row->slug);
                })
                ->addColumn('nilai_evaluasi', function ($row) {
                    return $this->getNialiEvaluasi($row->id);
                })
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('rekapDeskEvaluasi.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }

    private function getNilaiDeskEvaluasi($id, $slug)
    {
            $poin = DB::table('poin_prodi')
                ->select(
                    'fakultas_prodi_id',
                    DB::raw('COUNT(DISTINCT poin_id) as total_poin_id')
                )
                ->where('fakultas_prodi_id', $id)
                ->groupBy('fakultas_prodi_id')
                ->get();

                
                $data = DB::table('daftar_temuan_audits')
                ->join('users', 'daftar_temuan_audits.user_id', '=', 'users.id')
                ->join('fakultas_prodis', 'users.fakultas_id', '=', 'fakultas_prodis.id')
                ->where('daftar_temuan_audits.prodi', $slug)
                ->sum('daftar_temuan_audits.status');
                log()->info($data);
                // return $data;
                return $data / $poin[0]->total_poin_id;
    }

        private function getNialiEvaluasi($id)
    {

         $poin = DB::table('poin_prodi')
                ->select(
                    'fakultas_prodi_id',
                    DB::raw('COUNT(DISTINCT poin_id) as total_poin_id')
                )
                ->where('fakultas_prodi_id', $id)
                ->groupBy('fakultas_prodi_id')
                ->get();
           $data = Jawaban::join('users', 'jawabans.user_id', '=', 'users.id')
            ->where('users.fakultas_id', $id)
            ->sum('jawabans.jawaban');

        return $data / $poin[0]->total_poin_id;
    }
}
