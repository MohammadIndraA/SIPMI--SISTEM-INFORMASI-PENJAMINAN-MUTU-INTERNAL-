<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaftarStandarRequest;
use App\Models\DaftarStandar;
use App\Models\LembagaAkreditasi;
use App\Models\TahunPeriode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class DaftarStandarController extends Controller
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


    public function store(DaftarStandarRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui PermissionRequest
            $data = $request->validated();
            $data['daftar_standar_mutu_id'] = $request->id; 
            $daftarStandar = DaftarStandar::create($data);
            return response()->json([
                "status" => true,
                "data" => $daftarStandar,
                "message" => "Data Standa berhasil ditambahkan"
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
            $daftarStandar = DaftarStandar::findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $daftarStandar,
        ]);
    }

    public function update(DaftarStandarRequest $request, $id)
    {
        try {
            $daftarStandar = DaftarStandar::findOrFail($id);
            $data = $request->validated();  

            $daftarStandar->update($data); 

            return response()->json([
                "status" => true,
                "data" => $daftarStandar,
                "message" => "Data Standar berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Standar tidak ditemukan",
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
            $daftarStandar = DaftarStandar::findOrFail($request->id);
            $daftarStandar->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Standar berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Standar tidak ditemukan",
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
