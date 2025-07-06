<?php

namespace App\Http\Controllers;

use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;

class EvaluasiDiriController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-evaluasi-diri', ['only' => ['index','show']]),
        ];
    }
   private function getJumlahSudahMenjawab($fakultas_prodi_id)
    {
        // Ambil poin_id dari tabel poin_prodi sesuai fakultas_prodi_id
        $poin_ids = DB::table('poin_prodi')
            ->where('fakultas_prodi_id', $fakultas_prodi_id)
            ->pluck('poin_id');

        if ($poin_ids->isEmpty()) {
            return 0;
        }

        // Ambil jawaban yang:
        // - poin_id ada di dalam $poin_ids
        // - dan user yang membuatnya memiliki fakultas_id = $fakultas_prodi_id
        $data = Jawaban::join('users', 'jawabans.user_id', '=', 'users.id')
            ->whereIn('jawabans.poin_id', $poin_ids)
            ->where('users.fakultas_id', $fakultas_prodi_id)
            ->count();
        log()->info($data);
        return $data;
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
                ->addColumn('sudah_menjawab', function ($row) {
                    // log($row);
                        return $this->getJumlahSudahMenjawab($row->id);
                    })
                    ->addColumn('belum_menjawab', function ($row) {
                        $total = DB::table('poin_prodi')->where('fakultas_prodi_id', $row->id)->count();
                        $sudah = $this->getJumlahSudahMenjawab($row->id);
                        return max(0, $total - $sudah);
                    })
                ->rawColumns(['sudah_menjawab', 'belum_menjawab'])
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('evaluasiDiri.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }
}
