<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaftarStandarMutuRequest;
use App\Models\DaftarStandarMutu;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class DaftarStandarMutuController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-daftar-standar-mutu', ['only' => ['index','show']]),
            new Middleware('permission:create-daftar-standar-mutu', ['only' => ['create','store']]),
            new Middleware('permission:edit-daftar-standar-mutu', ['only' => ['edit','update']]),
            new Middleware('permission:delete-daftar-standar-mutu', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $daftarStandarMutu = DB::table('daftar_standar_mutus')
            ->leftJoin('daftar_standars', 'daftar_standars.daftar_standar_mutu_id', '=', 'daftar_standar_mutus.id')
            ->select(
                'daftar_standar_mutus.*',
                'daftar_standars.id as daftar_standar_id',
                'daftar_standars.nama_standar'
            )
            ->orderBy('daftar_standar_mutus.id', 'desc')
            ->when($request->filled('tahun_periode_id'), function ($query) use ($request) {
                $query->where('tahun_periode_id', $request->tahun_periode_id);
            })
            ->when($request->filled('lembaga_akreditasi_id'), function ($query) use ($request) {
                $query->where('lembaga_akreditasi_id', $request->lembaga_akreditasi_id);
            });    
            return datatables($daftarStandarMutu)
                ->addIndexColumn()
                ->editColumn('nama_standar_mutu', function ($row) {
                   $data = ' <details>
                        <summary class="withJS">' . $row->nama_standar_mutu . '</summary>
                        <details>
                                <summary class="withJS p-3">'.  $row->nama_standar .'</summary>
                                       <ul class="pe-5">
                                       <li class="ms-3">
                                        '.   $row->nama_standar_mutu .'
                                       </li>
                        </details>
                    </details>';
                    return $data;
                })                
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-daftar-standar-mutu')) {
                        $addButton = '
                            <button onclick="addStandar(`' . $row->id . '`)" class="btn btn-warning btn-flat btn-sm" title="Tambah Standar">
                                <i class="uil-comment-plus"></i>
                            </button>
                        ';
                    }

                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-daftar-standar-mutu')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-daftar-standar-mutu')) {
                        $deleteButton = '
                            <button onclick="deleteFunc(`' . $row->id . '`)" class="btn btn-danger btn-flat btn-sm" title="Delete">
                                <i class="dripicons-trash"></i>
                            </button>
                        ';
                    }
                
                    // Gabungkan semua tombol dalam satu grup
                    return '
                        <div class="btn-group">
                            ' . $addButton . '
                            ' . $editButton . '
                            ' . $deleteButton . '
                        </div>
                    ';
                })
                ->rawColumns(['action','nama_standar_mutu'])
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('daftarStandarMutu.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }

    public function store(DaftarStandarMutuRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui PermissionRequest
            $daftarStandarMutu = DaftarStandarMutu::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $daftarStandarMutu,
                "message" => "Data Standar Mutu berhasil ditambahkan"
            ], 201); // HTTP Status 201 untuk created
        } catch (\Exception $e) {
            // Tangkap error yang terjadi
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
                "error" => $e->getMessage(), // Pesan error untuk debugging
            ], 500); // HTTP Status 500 untuk internal server error
        }
    }

    public function edit(Request $request)
    {
            $daftarStandarMutu = DaftarStandarMutu::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $daftarStandarMutu,
        ]);
    }

    public function update(DaftarStandarMutuRequest $request, $id)
    {
        try {
            $daftarStandarMutu = DaftarStandarMutu::findOrFail($id);
            $data = $request->validated();  

            $daftarStandarMutu->update($data); 

            return response()->json([
                "status" => true,
                "data" => $daftarStandarMutu,
                "message" => "Data Standar Mutu berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Standar Mutu tidak ditemukan",
            ], 404); // HTTP Status 404 untuk not found
        } catch (\Exception $e) {
            // Tangkap error lain yang mungkin terjadi
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
                "error" => $e->getMessage(), // Opsional, untuk debugging
            ], 500); // HTTP Status 500 untuk internal server error
        }
    }
    
    public function destroy(Request $request)
    {
        try {
            $daftarStandarMutu = DaftarStandarMutu::findOrFail($request->id);
            $daftarStandarMutu->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Standar Mutu berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Standar Mutu tidak ditemukan",
            ], 404); // HTTP Status 404 untuk not found
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
                "error" => $e->getMessage(), // Opsional, untuk debugging
            ], 500); // HTTP Status 500 untuk internal server error
        }
    }
}
