<?php

namespace App\Http\Controllers;

use App\Http\Requests\daftarNilaiMutuRequest;
use App\Models\DaftarNilaiMutu;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class DaftarNilaiMutuController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-daftar-nilai-mutu', ['only' => ['index','show']]),
            new Middleware('permission:create-daftar-nilai-mutu', ['only' => ['create','store']]),
            new Middleware('permission:edit-daftar-nilai-mutu', ['only' => ['edit','update']]),
            new Middleware('permission:delete-daftar-nilai-mutu', ['only' => ['destroy']]),
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DaftarNilaiMutu::orderBy('id', 'desc')
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
                    if (auth()->user()->can('edit-daftar-nilai-mutu')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-daftar-nilai-mutu')) {
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
        return view('daftarNilaiMutu.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }

    public function store(daftarNilaiMutuRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui StandarNasionalRequest
            $data = $request->validated();
            $daftarNilaiMutu = DaftarNilaiMutu::create($data);
            return response()->json([
                "status" => true,
                "data" => $daftarNilaiMutu,
                "message" => "Data Daftar Nilai Mutu berhasil ditambahkan"
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
        $daftarNilaiMutu = DaftarNilaiMutu::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $daftarNilaiMutu,
        ]);
    }

    public function update(daftarNilaiMutuRequest $request, $id)
    {
        try {
            $daftarNilaiMutu = DaftarNilaiMutu::findOrFail($id);

            $data = $request->validated();  
            $daftarNilaiMutu->update($data);

            return response()->json([
                "status" => true,
                "data" => $daftarNilaiMutu,
                "message" => "Data Daftar Nilai Mutu berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Daftar Nilai Mutu tidak ditemukan",
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
            $daftarNilaiMutu = DaftarNilaiMutu::findOrFail($request->id);
            $daftarNilaiMutu->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Daftar Nilai Mutu berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Daftar Nilai Mutu tidak ditemukan",
            ], 404); // HTTP Status 404 untuk not found
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Data ini tidak bisa di hapus karena sudah digunakan",
                "error" => $e->getMessage(), // Opsional, untuk debugging
            ], 500); // HTTP Status 500 untuk internal server error
        }
    }
}
