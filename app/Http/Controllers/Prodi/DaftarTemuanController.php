<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Http\Requests\FakultasProdiRequest;
use App\Models\FakultasProdi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class DaftarTemuanController extends Controller
{
     public static function middleware()
    {
        return [
            new Middleware('permission:view-daftar-temuan', ['only' => ['index','show']]),
            new Middleware('permission:create-daftar-temuan', ['only' => ['create','store']]),
        ];
    }
        public function index(Request $request)
    {
        if ($request->ajax()) {
            $fakultasProdi = FakultasProdi::orderBy('id', 'desc');
            return datatables($fakultasProdi)
                ->addIndexColumn()
              ->editColumn('fakultas', function($row) {
                    $data = "";
                    $data .= $row->fakultas_prodi;
                    $data .= "<br>";
                   $data .= '<button onclick="rencanaTindakLanjut(\'' . route('prodi.rencana-tindak-lanjut.store', $row->id) . '\')" class="btn btn-warning btn-flat btn-sm mt-2" title="Edit">
                                <i class="dripicons-document-edit"></i> Rencana Tindak Lanjut 
                            </button>';
                    return $data;
                })
                ->rawColumns(['fakultas'])
                ->make(true);
        }
        return view('prodi.daftarTemuan.index');
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
}
