<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahunPeriodeRequest;
use App\Models\TahunPeriode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class TahunPeriodeController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-tahun-periode', ['only' => ['index','show']]),
            new Middleware('permission:create-tahun-periode', ['only' => ['create','store']]),
            new Middleware('permission:edit-tahun-periode', ['only' => ['edit','update']]),
            new Middleware('permission:delete-tahun-periode', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tahunPeriode = TahunPeriode::orderBy('id', 'desc');
            return datatables($tahunPeriode)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-tahun-periode')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-tahun-periode')) {
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
        return view('tahunPeriode.index');
    }

    public function store(TahunPeriodeRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui PermissionRequest
            $tahunPeriode = TahunPeriode::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $tahunPeriode,
                "message" => "Data Permission berhasil ditambahkan"
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
            $tahunPeriode = TahunPeriode::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $tahunPeriode,
        ]);
    }

    public function update(TahunPeriodeRequest $request, $id)
    {
        try {
            $tahunPeriode = TahunPeriode::findOrFail($id);
            $data = $request->validated();  

            $tahunPeriode->update($data); 

            return response()->json([
                "status" => true,
                "data" => $tahunPeriode,
                "message" => "Data Permission berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Permission tidak ditemukan",
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
            $tahunPeriode = TahunPeriode::findOrFail($request->id);
            $tahunPeriode->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Permission berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Permission tidak ditemukan",
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
