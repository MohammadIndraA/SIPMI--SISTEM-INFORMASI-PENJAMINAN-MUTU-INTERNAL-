<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\DaftarTemuanAudit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;

class RekapDaftarTemuanController extends Controller
{    

    public static function middleware()
    {
        return [
            new Middleware('permission:view-rekap-daftar-temuan', ['only' => ['index','show']]),
        ];
    }
    
    public function index()
    {
        return view('auditor.rekapDaftarTemuan.index');
    }

    public function simpan_jawaban_audit(Request $request)
    {
         try {
            $request->validate([
                    'status' => 'required|array',
                    'status.*' => 'in:Terverifikasi,Membutuhkan Perbaikan,Tidak Terbukti', // Setiap nilai harus salah satu dari ini
                ]);
            // Data sudah tervalidasi melalui LembagaAkreditasiRequest
    
             foreach ($request->status as $poinId => $status) {
              $data =  DaftarTemuanAudit::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'poin_id' => $poinId,
                    ],
                    [
                        'daftar_sub_standar_id' => $request->sub_standar_id,
                        'status' => $status,
                        'temuan' => $request->temuan[$poinId] ?? null,
                        'rekomendasi' => $request->rekomendasi[$poinId] ?? null,
                        'prodi' => $request->prodi_fakultas,
                    ]
                );
            }
            return response()->json([
                "status" => true,
                "data" => $data,
                "message" => "Data berhasil ditambahkan"
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
