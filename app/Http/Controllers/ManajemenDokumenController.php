<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManajemenDokumenRequest;
use App\Models\KategoriDokumen;
use App\Models\ManajemenDokumen;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class ManajemenDokumenController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-manajemen-dokumen', ['only' => ['index','show']]),
            new Middleware('permission:create-manajemen-dokumen', ['only' => ['create','store']]),
            new Middleware('permission:edit-manajemen-dokumen', ['only' => ['edit','update']]),
            new Middleware('permission:delete-manajemen-dokumen', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $manajemenDokumen = ManajemenDokumen::orderBy('id', 'desc');
            return datatables($manajemenDokumen)
                ->addIndexColumn()
                ->editColumn('file_dokumen', function($queri) {
                    $fileUrl = asset('storage/' . $queri->file_dokumen); // URL file
                // Tampilkan tautan untuk pratinjau file
                return '<a href="' . $fileUrl . '" target="_blank"><i class="mdi mdi-file-pdf" style="font-size: 24px; color: red;"></i></a>';
                })
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-manajemen-dokumen')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`)" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-manajemen-dokumen')) {
                        $deleteButton = '
                            <button onclick="deleteFunc(`' . $row->id . '`)" class="btn btn-danger btn-flat btn-sm" title="Delete">
                                <i class="dripicons-trash"></i>
                            </button>
                        ';
                    }
                
                    // Gabungkan semua tombol dalam satu grup
                    return '
                        <div class="btn-group">
                            ' . $editButton . '
                            ' . $deleteButton . '
                        </div>
                    ';
                })
                ->rawColumns(['action', 'file_dokumen'])
                ->make(true);
        }
        $kategoriDokumens = KategoriDokumen::all();
        return view('manajemenDokumen.index', compact('kategoriDokumens'));
    }

    public function store(ManajemenDokumenRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui ManajemenDokumenRequest
            $data = $request->validated();
            if ($request->hasFile('file_dokumen')) {
                $data['file_dokumen'] = uploadDokumen('dokumen/kategori', $request->file('file_dokumen'));
            }
            $manajemenDokumen = ManajemenDokumen::create($data);
            return response()->json([
                "status" => true,
                "data" => $manajemenDokumen,
                "message" => "Data manajemen dokumen berhasil ditambahkan"
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
            $manajemenDokumen = ManajemenDokumen::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $manajemenDokumen,
        ]);
    }

    public function update(ManajemenDokumenRequest $request, $id)
    {
        try {
            $manajemenDokumen = ManajemenDokumen::findOrFail($id);
            $data = $request->validated();
            if ($request->hasFile('file_dokumen')) {
                if (Storage::disk('public')->exists($manajemenDokumen->file_dokumen)) {
                   Storage::disk('public')->delete($manajemenDokumen->file_dokumen);
                }
                $data['file_dokumen'] = uploadDokumen('dokumen/kategori', $request->file('file_dokumen'));
            }  

            $manajemenDokumen->update($data); 

            return response()->json([
                "status" => true,
                "data" => $manajemenDokumen,
                "message" => "Data manajemen dokumen berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data manajemen dokumen tidak ditemukan",
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
            $manajemenDokumen = ManajemenDokumen::findOrFail($request->id);
            if (Storage::disk('public')->exists($manajemenDokumen->file_dokumen)) {
                Storage::disk('public')->delete($manajemenDokumen->file_dokumen);
            }
            $manajemenDokumen->delete();
            return response()->json([
                "status" => true,
                "message" => "Data manajemen dokumen berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data manajemen dokumen tidak ditemukan",
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
