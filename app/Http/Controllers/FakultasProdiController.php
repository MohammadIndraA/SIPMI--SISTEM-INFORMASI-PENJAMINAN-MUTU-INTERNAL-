<?php

namespace App\Http\Controllers;

use App\Http\Requests\FakultasProdiRequest;
use App\Models\FakultasProdi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class FakultasProdiController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('Fakultas Prodi:view-fakultas-prodi', ['only' => ['index','show']]),
            new Middleware('Fakultas Prodi:create-fakultas-prodi', ['only' => ['create','store']]),
            new Middleware('Fakultas Prodi:edit-fakultas-prodi', ['only' => ['edit','update']]),
            new Middleware('Fakultas Prodi:delete-fakultas-prodi', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $fakultasProdi = FakultasProdi::orderBy('id', 'desc');
            return datatables($fakultasProdi)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-fakultas-prodi')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-fakultas-prodi')) {
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
        return view('fakultasProdi.index');
    }

    public function store(FakultasProdiRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui Fakultas ProdiRequest
            $fakultasProdi = FakultasProdi::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $fakultasProdi,
                "message" => "Data Fakultas Prodi berhasil ditambahkan"
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
            $fakultasProdi = FakultasProdi::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $fakultasProdi,
        ]);
    }

    public function update(FakultasProdiRequest $request, $id)
    {
        try {
            $fakultasProdi = FakultasProdi::findOrFail($id);
            $data = $request->validated();  

            $fakultasProdi->update($data); 

            return response()->json([
                "status" => true,
                "data" => $fakultasProdi,
                "message" => "Data Fakultas Prodi berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Fakultas Prodi tidak ditemukan",
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
            $fakultasProdi = FakultasProdi::findOrFail($request->id);
            $fakultasProdi->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Fakultas Prodi berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Fakultas Prodi tidak ditemukan",
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
