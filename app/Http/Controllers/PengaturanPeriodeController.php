<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengaturanPeriodeRequest;
use App\Models\LembagaAkreditasi;
use App\Models\PengaturanPeriode;
use App\Models\StandarNasional;
use App\Models\TahunPeriode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class PengaturanPeriodeController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-pengaturan-periode', ['only' => ['index','show']]),
            new Middleware('permission:create-pengaturan-periode', ['only' => ['create','store']]),
            new Middleware('permission:edit-pengaturan-periode', ['only' => ['edit','update']]),
            new Middleware('permission:delete-pengaturan-periode', ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pengaturanPeriode = PengaturanPeriode::orderBy('id', 'desc');
            return datatables($pengaturanPeriode)
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
        $standarNasionals = StandarNasional::all();
        return view('pengaturanPeriode.index', compact('tahunPeriodes', 'lembagaAkreditasis', 'standarNasionals'));
    }

    public function store(PengaturanPeriodeRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui StandarNasionalRequest
            $data = $request->validated();
            $pengaturanPeriode = PengaturanPeriode::create($data);
            $pengaturanPeriode->standar_nasionals()->attach($request->standar_nasional_id);
            return response()->json([
                "status" => true,
                "data" => $pengaturanPeriode,
                "message" => "Data pengaturan periode berhasil ditambahkan"
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
        $pengaturanPeriode = PengaturanPeriode::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $pengaturanPeriode,
        ]);
    }

    public function update(PengaturanPeriodeRequest $request, $id)
    {
        try {
            $pengaturanPeriode = PengaturanPeriode::findOrFail($id);

            $data = $request->validated();  
            $pengaturanPeriode->update($data);
            $pengaturanPeriode->standar_nasionals()->sync($request->standar_nasional_id); 

            return response()->json([
                "status" => true,
                "data" => $pengaturanPeriode,
                "message" => "Data pengaturan periode berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data pengaturan periode tidak ditemukan",
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
            $pengaturanPeriode = PengaturanPeriode::findOrFail($request->id);
            $pengaturanPeriode->delete();
            return response()->json([
                "status" => true,
                "message" => "Data pengaturan periode berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data pengaturan periode tidak ditemukan",
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
