<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\EvaluasiDiri;
use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\PengaturanPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class EvaluasiDiriController extends Controller
{
     public static function middleware()
    {
        return [
            new Middleware('permission:view-evaluasi-diri', ['only' => ['index','show']]),
        ];
    }
     public function index()
    {
        $periode = PengaturanPeriode::first(['awal_periode_evaluasi_diri','akhir_periode_evaluasi_diri']);
        // dd($periode);
        $fakultas = FakultasProdi::where('id',auth()->user()->fakultas_id)->first();
        return view('prodi.evaluasiDiri.index', compact('fakultas', 'periode'));
    }

    public function simpan_jawaban(Request $request){
        // dd($request->all());
         try {
            $request->validate([
                    'poin' => 'required|array',
                    'poin.*' => 'in:1,2,3,4', // Setiap nilai harus salah satu dari ini
                ]);
            // Data sudah tervalidasi melalui LembagaAkreditasiRequest
             foreach ($request->poin as $poinId => $jawaban) {
              $data =  Jawaban::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'poin_id' => $poinId,
                    ],
                    [
                        'daftar_sub_standar_id' => $request->sub_standar_id,
                        'jawaban' => $jawaban,
                        'catatan' => $request->catatan[$poinId] ?? null,
                    ]
                );

                // EvaluasiDiri::updateOrCreate(
                //     [
                //         'lembaga_akreditasi_id' => auth()->id(),
                //         'fakultas_prodi_id' => $poinId,
                //     ],
                //     [
                //         'target_nilai_mutu' => $request->sub_standar_id,
                //         'nilai_evaluasi' => $jawaban,
                //         'sudah_menjawab' => $jawaban,
                //         'belum_menjawab' => $jawaban,
                //     ]
                // );
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
