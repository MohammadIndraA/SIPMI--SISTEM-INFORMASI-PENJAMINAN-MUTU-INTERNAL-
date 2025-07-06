<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\DaftarTemuanAudit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RekapDaftarTemuanController extends Controller
{    

    public static function middleware()
    {
        return [
            new Middleware('permission:view-rekap-daftar-temuan', ['only' => ['index','show']]),
        ];
    }
    
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $query = DB::table('fakultas_prodis')
            ->leftJoin('daftar_temuans', 'fakultas_prodis.id', '=', 'daftar_temuans.fakultas_prodi_id')
            ->leftJoin('evaluasi_diris', 'fakultas_prodis.id', '=', 'evaluasi_diris.fakultas_prodi_id')
            ->select(
                'fakultas_prodis.*',
                DB::raw('COUNT(daftar_temuans.id) as total_temuan'), // semua temuan
                DB::raw('SUM(IF(daftar_temuans.jumlah_temuan_disetujui = 1, 1, 0)) as total_temuan_disetujui'), // temuan yang benar-benar disetujui
                DB::raw('MAX(daftar_temuans.jumlah_temuan) as jumlah_temuan') // ambil salah satu jika ada banyak
            )
            ->when($request->filled('tahun_periode_id'), function ($q) use ($request) {
                $q->where('daftar_temuans.tahun_periode_id', $request->tahun_periode_id);
            })
            ->when($request->filled('lembaga_akreditasi_id'), function ($q) use ($request) {
                $q->where('daftar_temuans.lembaga_akreditasi_id', $request->lembaga_akreditasi_id);
            })
            ->groupBy('fakultas_prodis.id');      
            return datatables($query)
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
                        'prodi' => $request->prodi_fakultas,
                        'daftar_sub_standar_id' => $request->sub_standar_id,
                    ],
                    [
                        'status' => $status,
                        'temuan' => $request->temuan[$poinId] ?? null,
                        'rekomendasi' => $request->rekomendasi[$poinId] ?? null,
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
