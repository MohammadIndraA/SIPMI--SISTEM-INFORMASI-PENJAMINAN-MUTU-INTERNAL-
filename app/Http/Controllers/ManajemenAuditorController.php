<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManajemenAuditorRequest;
use App\Models\FakultasProdi;
use App\Models\LembagaAkreditasi;
use App\Models\ManajemenAuditor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class ManajemenAuditorController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('Fakultas Prodi:view-manajemen-auditor', ['only' => ['index','show']]),
            new Middleware('Fakultas Prodi:create-manajemen-auditor', ['only' => ['create','store']]),
            new Middleware('Fakultas Prodi:edit-manajemen-auditor', ['only' => ['edit','update']]),
            new Middleware('Fakultas Prodi:delete-manajemen-auditor', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $manajemenAuditor = ManajemenAuditor::orderBy('id', 'desc');
            return datatables($manajemenAuditor)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-manajemen-auditor')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-manajemen-auditor')) {
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
        $fakultasProdi = FakultasProdi::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('manajemenAuditor.index', compact('fakultasProdi', 'lembagaAkreditasis'));
    }

    public function store(ManajemenAuditorRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui Fakultas ProdiRequest
            $manajemenAuditor = ManajemenAuditor::create($request->validated());
            $manajemenAuditor->fakultas_prodis()->attach($request->fakultas_prodi_id);
            return response()->json([
                "status" => true,
                "data" => $manajemenAuditor,
                "message" => "Data Auditor berhasil ditambahkan"
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
            $manajemenAuditor = ManajemenAuditor::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $manajemenAuditor,
        ]);
    }

    public function update(ManajemenAuditorRequest $request, $id)
    {
        try {
            $manajemenAuditor = ManajemenAuditor::findOrFail($id);
            $manajemenAuditor->fakultas_prodis()->sync($request->fakultas_prodi_id);
            $data = $request->validated();  

            $manajemenAuditor->update($data); 

            return response()->json([
                "status" => true,
                "data" => $manajemenAuditor,
                "message" => "Data Auditor berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Auditor tidak ditemukan",
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
            $manajemenAuditor = ManajemenAuditor::findOrFail($request->id);
            $manajemenAuditor->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Auditor berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Auditor tidak ditemukan",
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
