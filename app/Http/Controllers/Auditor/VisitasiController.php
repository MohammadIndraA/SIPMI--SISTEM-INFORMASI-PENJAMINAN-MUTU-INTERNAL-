<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\BuktiPendukung;
use App\Models\DaftarSubStandar;
use App\Models\DaftarTemuan;
use App\Models\DaftarTemuanAudit;
use App\Models\FakultasProdi;
use App\Models\Jawaban;
use App\Models\KategoriDokumen;
use App\Models\PengaturanPeriode;
use App\Models\StandarNasional;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class VisitasiController extends Controller
{

      public static function middleware()
    {
        return [
            new Middleware('permission:view-visitasi', ['only' => ['index','show']]),
        ];
    }

      public function index()
    {
        $standar_nasionals = StandarNasional::all();
        $fakultas_prodis = FakultasProdi::all();
        $periode = PengaturanPeriode::first(['awal_periode_visitasi','akhir_periode_visitasi']);
        return view('auditor.visitasi.index', compact('standar_nasionals', 'fakultas_prodis', 'periode'));
    }

       public function data(Request $request)
    {
        $lastSegment = collect(request()->segments())->last();
       $nameSegement = collect(request()->segments())->slice(-2, 1)->first();
        $kategori_dokumens = KategoriDokumen::all();
        $sub_standars = DaftarSubStandar::with([
                        'daftar_standar_mutu.tahun_periode',
                        'daftar_standar_mutu.lembaga_akreditasi',
                          'poins' => function ($query) use ($nameSegement) {
                                $query->whereHas('prodis', function ($q) use ($nameSegement) {
                                    $q->where('fakultas_prodis.slug', $nameSegement);
                                });
                            },
                            'poins.prodis'
                    ])->where('slug', $lastSegment)->firstOrFail();
       $tahun = $sub_standars->daftar_standar_mutu->tahun_periode;
       $lembaga = $sub_standars->daftar_standar_mutu->lembaga_akreditasi;
       $fakultas_id = FakultasProdi::where('slug', $nameSegement)->first()->id;
        $jawabans = Jawaban::with('user')->where('daftar_sub_standar_id', $sub_standars->id)->get()->keyBy('poin_id');
        $jawaban_auditor = DaftarTemuanAudit::where('prodi', $nameSegement)->where('daftar_sub_standar_id', $sub_standars->id)->get()->keyBy('poin_id');
        $file_pendukungs = BuktiPendukung::where('daftar_sub_standar_id', $sub_standars->id)->get()->groupBy('poin_id');
        $jawaban_visitasi = DaftarTemuan::where('lembaga_akreditasi_id', $sub_standars->daftar_standar_mutu->lembaga_akreditasi_id)
                                        ->where('tahun_periode_id', $sub_standars->daftar_standar_mutu->tahun_periode_id)
                                        ->where('fakultas_prodi_id', $fakultas_id)->get()->keyBy('poin_id');
        // dd($jawaban_visitasi);
        return view('auditor.visitasi.data_store', compact('kategori_dokumens', 'sub_standars', 'jawabans', 'tahun', 'lembaga', 'file_pendukungs', 'jawaban_auditor','jawaban_visitasi'));
    }

    public function simpan_visitasi_auditor(Request $request)
    {
        // dd($request->all());
           try {
            $request->validate([
                    'status_visitasi' => 'required|array',
                    'jumlah_temuan' => 'required',
                    'status.*' => 'in:disetujui,tidak disetujui', // Setiap nilai harus salah satu dari ini
                ]);
            // Data sudah tervalidasi melalui LembagaAkreditasiRequest
             $fakultas_prodi = FakultasProdi::where('slug', $request->prodi_fakultas)->first();   
             foreach ($request->status_visitasi as $poinId => $status) {
              $data =  DaftarTemuan::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'poin_id' => $poinId,
                        'tahun_periode_id' => $request->tahun_periode_id,
                        'lembaga_akreditasi_id' => $request->lembaga_akreditasi_id,
                        'fakultas_prodi_id' => $fakultas_prodi->id,
                    ],
                    [
                        'jumlah_temuan_disetujui' => $status == "disetujui" ? "1" : "0",
                        'jumlah_temuan' => $request->jumlah_temuan[$poinId] ?? null,
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
