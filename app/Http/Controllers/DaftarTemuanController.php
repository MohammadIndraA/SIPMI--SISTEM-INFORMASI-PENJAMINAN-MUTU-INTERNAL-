<?php

namespace App\Http\Controllers;

use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class DaftarTemuanController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-daftar-temuan', ['only' => ['index','show']]),
        ];
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = DB::table('fakultas_prodis')
            ->leftJoin('daftar_temuans', 'fakultas_prodis.id', '=', 'daftar_temuans.fakultas_prodi_id')
            ->leftJoin('evaluasi_diris', 'fakultas_prodis.id', '=', 'evaluasi_diris.fakultas_prodi_id')
            ->select('fakultas_prodis.*', 'daftar_temuans.jumlah_temuan', 'daftar_temuans.jumlah_temuan_disetujui')
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
                    if (auth()->user()->can('edit-pengaturan-periode')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-pengaturan-periode')) {
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
        return view('daftarTemuan.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }
}
