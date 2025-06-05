<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Requests\RencanaTindakLanjutRequest;
use App\Models\RencanaTindakLanjut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;

class RencanaTindakLanjutController extends Controller
{
     public static function middleware()
    {
        return [
            new Middleware('permission:view-rencana-tindak-lanjut', ['only' => ['index','show']]),
        ];
    }
      public function store(RencanaTindakLanjutRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui Fakultas ProdiRequest
            $rencana_tindak_lanjut = RencanaTindakLanjut::create($request->validated());
            return response()->json([
                "status" => true,
                "data" => $rencana_tindak_lanjut,
                "message" => "Data Rencana Tindak Lanjut berhasil ditambahkan"
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
