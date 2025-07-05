<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\DaftarStandarMutu;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class StandarMutuController extends Controller
{
       public static function middleware()
    {
        return [
            new Middleware('permission:view-standar-mutu', ['only' => ['index','show']]),
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
                                    $url = "";
                                       if(request()->is('*visitasi*')) {
                                           // Jika URL mengandung 'rekap-desk-evaluasi', tambahkan tambahan path
                                            $url = url('/auditor/visitasi/' . request()->segment(3) . '/' . $daftar_sub_standar->slug);
                                           } else {
                                           // URL normal
                                           $url = url('/auditor/substandar/' . request()->segment(3) . '/' . $daftar_sub_standar->slug);
                                       }
                            $data .= '
                                        <div class="inline col-12 position-relative">
                                            <details open>
                                                <summary class="ps-2 ms-3">
                                                    <b>' . $daftar_sub_standar->nama_sub_standar . '</b>
                                                    <hr/>
                                                </summary>

                                                <!-- Tombol Star di pojok kanan -->
                                                <div class="position-absolute top-0 end-0 me-3">
                                                    <a href="' . $url . '" 
                                                    class="btn btn-primary btn-sm"  
                                                    style="cursor: pointer;">
                                                    Pilih <i class="mdi mdi-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </details>
                                        </div>';
                                }
                            }
                
                            $data .= '</details>';
                        }
                    }
                    $data .= '</details>';
                    return $data;
                })             
                ->rawColumns(['nama_standar_mutu'])
                ->make(true);
        }
        $tahunPeriodes = TahunPeriode::all();
        $lembagaAkreditasis = LembagaAkreditasi::all();
        return view('auditor.standarMutu.index', compact('tahunPeriodes', 'lembagaAkreditasis'));
    }
}
