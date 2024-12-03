<?php

namespace App\Http\Controllers;

use App\Http\Requests\LembagaAkreditasiRequest;
use App\Models\LembagaAkreditasi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class LembagaAkreditasiController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-lembaga-akreditasi', ['only' => ['index','show']]),
            new Middleware('permission:create-lembaga-akreditasi', ['only' => ['create','store']]),
            new Middleware('permission:edit-lembaga-akreditasi', ['only' => ['edit','update']]),
            new Middleware('permission:delete-lembaga-akreditasi', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lembagaAkreditasi = LembagaAkreditasi::orderBy('id', 'desc');
            return datatables($lembagaAkreditasi)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-lembaga-akreditasi')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-lembaga-akreditasi')) {
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
        return view('lembagaAkreditasi.index');
    }

    public function store(LembagaAkreditasiRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui LembagaAkreditasiRequest
            $lembagaAkreditasi = LembagaAkreditasi::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $lembagaAkreditasi,
                "message" => "Data Lembaga Akreditasi berhasil ditambahkan"
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
        $lembagaAkreditasi = LembagaAkreditasi::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $lembagaAkreditasi,
        ]);
    }

    public function update(LembagaAkreditasiRequest $request, $id)
    {
        try {
            $lembagaAkreditasi = LembagaAkreditasi::findOrFail($id);
            $data = $request->validated();  

            $lembagaAkreditasi->update($data); 

            return response()->json([
                "status" => true,
                "data" => $lembagaAkreditasi,
                "message" => "Data Lembaga Akreditasi berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Lembaga Akreditasi tidak ditemukan",
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
            $lembagaAkreditasi = LembagaAkreditasi::findOrFail($request->id);
            $lembagaAkreditasi->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Lembaga Akreditasi berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Lembaga Akreditasi tidak ditemukan",
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
