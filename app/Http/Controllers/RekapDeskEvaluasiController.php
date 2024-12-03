<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiDiri;
use App\Models\FakultasProdi;
use App\Models\LembagaAkreditasi;
use App\Models\RekapDeskEvaluasi;
use App\Models\TahunPeriode;
use App\Models\TargetNilaiMutu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

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
            ->leftJoin('target_nilai_mutus', 'fakultas_prodis.id', '=', 'target_nilai_mutus.fakultas_prodi_id')
            ->leftJoin('evaluasi_diris', 'fakultas_prodis.id', '=', 'evaluasi_diris.fakultas_prodi_id')
            ->leftJoin('rekap_desk_evaluasis', 'fakultas_prodis.id', '=', 'rekap_desk_evaluasis.fakultas_prodi_id')
            ->select('fakultas_prodis.*', 'target_nilai_mutus.target_nilai_mutu', 'evaluasi_diris.nilai_evaluasi', 'rekap_desk_evaluasis.nilai_desk_evaluasi')
            ->when($request->filled('tahun_periode_id'), function ($query) use ($request) {
                $query->where('tahun_periode_id', $request->tahun_periode_id);
            })
            ->when($request->filled('lembaga_akreditasi_id'), function ($query) use ($request) {
                $query->where('lembaga_akreditasi_id', $request->lembaga_akreditasi_id);
            });        
            return datatables($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-rekap-desk-evaluasi')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-rekap-desk-evaluasi')) {
                        $deleteButton = '
                            <button onclick="deleteFunc(`' . $row->id . '`)" class="btn btn-danger btn-flat btn-sm" title="Delete">
                                <i class="dripicons-trash"></i>
                            </button>
                        ';
                    }
                
                    // Gabungkan semua tombol dalam satu grup
                    return '
                        <div class="d-flex gap-1">
                            ' . $editButton . '
                            ' . $deleteButton . '
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('rekapDeskEvaluasi.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }
}
