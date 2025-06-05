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
        $daftarStandarMutu = DaftarStandarMutu::with('daftar_standars.daftar_sub_standars.poins')
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
                    $data = '<details open>
                                <summary style="margin: 0px;"><b>' . $row->nama_standar_mutu . '</b></summary>
                               <hr/>';
                
                    if ($row->daftar_standars) {
                        foreach ($row->daftar_standars as $daftar_standar) {
                            // $data .= ' <hr/>';
                            $data .= '<details open>
                                        <summary class="ps-2 ms-1"><b>' . $daftar_standar->nama_standar . '</b><hr/></summary> ';
                            
                            // Periksa apakah daftar_standar memiliki daftar_sub_standars
                            if ($daftar_standar->daftar_sub_standars && $daftar_standar->daftar_sub_standars->count() > 0) {
                                foreach ($daftar_standar->daftar_sub_standars as $daftar_sub_standar) {
                                    $data .= '<details open>
                                                <summary class="ps-2 ms-3"><b>' . $daftar_sub_standar->nama_sub_standar . '</b><hr/></summary>
                                              ';
                                    if ($daftar_sub_standar->poins && $daftar_sub_standar->poins->count() > 0) {
                                        $data .= '<ul class="ms-5 ps-2">'; // Buka <ul> di sini
                                        foreach ($daftar_sub_standar->poins as $poin) {
                                            $data .= '<div class="inline col-12" style="display: flex; align-items: center;">'; // Buka <div> untuk setiap poin
                                            $data .= '<li class="col-11"><p class="">' . $poin->nama_poin . '</p><hr></li>';
                                            $data .= '<div class="col-1"><a onclick="addIndikator(' . $poin->id . ')" class="" style="cursor: pointer;">indikator</a><hr></div>';
                                            $data .= '</div>'; // Tutup <div> untuk setiap poin
                                        }
                                        $data .= '</ul>'; // Tutup <ul> di sini
                                    }
                                    $data .= '</details>';
                                }
                            }
                
                            $data .= '</details>';
                        }
                    }
                    $data .= '</details>';
                    return $data;
                })             
                ->addColumn('action', function ($row) {
                    $editButton = '';
                    $deleteButton = '';
                
                    //button add daftar menu standar
                    if (auth()->user()->can('edit-daftar-standar-mutu')) {
                        $addButton = '
                            <button onclick="addStandar(\'' . $row->id . '\', \'daftar-standar-mutu\')" class="btn btn-warning btn-flat btn-sm" title="Tambah Data">
                                <i class="uil-comment-plus"></i>
                            </button>
                        ';
                    }

                    // Tambahkan tombol edit jika memiliki izin
                    if (auth()->user()->can('edit-daftar-standar-mutu')) {
                        $editButton = '
                            <button onclick="editFunc(`' . $row->id . '`, \'daftar-standar-mutu\')" class="btn btn-primary btn-flat btn-sm" title="Edit">
                                <i class="dripicons-document-edit"></i>
                            </button>
                        ';
                    }
                
                    // Tambahkan tombol delete jika memiliki izin
                    if (auth()->user()->can('delete-daftar-standar-mutu')) {
                        $deleteButton = '
                            <button onclick="deleteFunc(`' . $row->id . '`, \'daftar-standar-mutu\')" class="btn btn-danger btn-flat btn-sm" title="Delete">
                                <i class="dripicons-trash"></i>
                            </button>
                        ';
                    }
                
                    // Gabungkan semua tombol dalam satu grup

                   // button standar  // Tampilkan tombol aksi untuk daftar_standars dan daftar_sub_standars
        $buttons = '';

        if ($row->daftar_standars) {
            foreach ($row->daftar_standars as $daftar_standar) {
                // Tombol untuk daftar_standar
                $buttons .= '
                <div class="btn-group mb-3">
                    ' . generateAddButton($daftar_standar->id, 'Tambah Standar', 'daftar-standar', 'btn-warning', 'uil-comment-plus') . '
                    ' . generateEditButton($daftar_standar->id, 'Edit Standar', 'daftar-standar', 'btn-primary', 'dripicons-document-edit') . '
                    ' . deleteButton($daftar_standar->id, 'Hapus Standar', 'daftar-standar', 'btn-danger', 'dripicons-trash') . '
                </div>';

                // Tombol untuk daftar_sub_standar (jika ada)
                if ($daftar_standar->relationLoaded('daftar_sub_standars') && $daftar_standar->daftar_sub_standars->count() > 0) {
                    foreach ($daftar_standar->daftar_sub_standars as $daftar_sub_standar) {
                        $buttons .= '
                        <div class="btn-group mb-3">
                            ' . generateAddButton($daftar_sub_standar->id, 'Tambah Sub Standar', 'daftar-sub-standar', 'btn-warning', 'dripicons-plus') . '
                            ' . generateEditButton($daftar_sub_standar->id, 'Edit Sub Standar', 'daftar-sub-standar', 'btn-primary', 'dripicons-pencil') . '
                            ' . deleteButton($daftar_sub_standar->id, 'Hapus Sub Standar', 'daftar-sub-standar', 'btn-danger', 'dripicons-cross') . '
                        </div>';

                        // Tombol untuk poin (jika ada)
                        if ($daftar_sub_standar->relationLoaded('poins') && $daftar_sub_standar->poins->count() > 0) {
                            foreach ($daftar_sub_standar->poins as $poin) {
                                $buttons .= '
                                 <div class="btn-group pt-2 mb-3">
                            ' . generateEditButton($poin->id, 'Edit Poin', 'poin', 'btn-primary', 'dripicons-pencil') . '
                            ' . deleteButton($poin->id, 'Hapus Poin', 'poin', 'btn-danger', 'dripicons-cross') . '
                        </div>';
                            }
                        }
                    }
                }
            }
        }
                    
                    return '
                        <div class="btn-group">
                            ' . $addButton . '
                            ' . $editButton . '
                            ' . $deleteButton . '
                        </div> 
                        . ' . $buttons . '.
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
