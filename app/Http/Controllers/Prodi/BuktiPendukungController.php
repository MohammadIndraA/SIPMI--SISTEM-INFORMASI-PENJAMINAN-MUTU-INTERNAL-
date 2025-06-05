<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Requests\BuktiPendukungRequest;
use App\Models\BuktiPendukung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;

class BuktiPendukungController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-bukti-pendukung', ['only' => ['index','show']]),
            new Middleware('permission:create-bukti-pendukung', ['only' => ['create','store']]),
        ];
    }

      public function index(Request $request)
    {
        if ($request->ajax()) {
            $fakultasProdi = BuktiPendukung::with('kategori_dokumen')->orderBy('id', 'desc');
            return datatables($fakultasProdi)
                ->addIndexColumn()
                ->editColumn('kategori_dokumen', function ($row) {
                    return $row->kategori_dokumen->kategori;
                    dd($row->kategori_dokumen->kategori);
                })
               ->addColumn('action', function ($row) {
                return $row->file_pendukung != null
                    ? '<button type="button" class="btn btn-success" style="size: 50%"><i class="mdi mdi-check-bold"></i></button>'
                    : '<button type="button" class="btn btn-danger"><i class="mdi mdi-close-circle"></i></button>';
                })
                 ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function store(BuktiPendukungRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui LembagaAkreditasiRequest
            $data = $request->validated();
             if ($request->hasFile('file_pendukung')) {
                $data['file_pendukung'] = uploadDokumen('dokumen/pendukung', $request->file('file_pendukung'));
            }
            $data['unit_pengunggah'] = auth()->user()->getRoleNames()->first();
            $bukti_pendukung = BuktiPendukung::create($data);
            return response()->json([
                "status" => true,
                "data" => $bukti_pendukung,
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
}
