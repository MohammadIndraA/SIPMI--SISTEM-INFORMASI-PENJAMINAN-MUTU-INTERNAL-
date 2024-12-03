<?php

namespace App\Http\Controllers;

use App\Http\Requests\StandarNasionalRequest;
use App\Models\StandarNasional;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class StandarNasionalController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-standar-nasional', ['only' => ['index','show']]),
            new Middleware('permission:create-standar-nasional', ['only' => ['create','store']]),
            new Middleware('permission:edit-standar-nasional', ['only' => ['edit','update']]),
            new Middleware('permission:delete-standar-nasional', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $standarNasional = StandarNasional::orderBy('id', 'desc');
            return datatables($standarNasional)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-standar-nasional')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-standar-nasional')) {
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
        return view('standarNasional.index');
    }

    public function store(StandarNasionalRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui StandarNasionalRequest
            $standarNasional = StandarNasional::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $standarNasional,
                "message" => "Data Standar Naional berhasil ditambahkan"
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
        $standarNasional = StandarNasional::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $standarNasional,
        ]);
    }

    public function update(StandarNasionalRequest $request, $id)
    {
        try {
            $standarNasional = StandarNasional::findOrFail($id);
            $data = $request->validated();  

            $standarNasional->update($data); 

            return response()->json([
                "status" => true,
                "data" => $standarNasional,
                "message" => "Data Standar Naional berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Standar Naional tidak ditemukan",
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
            $standarNasional = StandarNasional::findOrFail($request->id);
            $standarNasional->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Standar Naional berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Standar Naional tidak ditemukan",
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
