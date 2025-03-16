<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoinRequest;
use App\Models\Poin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class PoinController extends Controller
{
    
    public static function middleware()
    {
        return [
            new Middleware('permission:view-daftar-sub-standar', ['only' => ['index','show']]),
            new Middleware('permission:create-daftar-sub-standar', ['only' => ['create','store']]),
            new Middleware('permission:edit-daftar-sub-standar', ['only' => ['edit','update']]),
            new Middleware('permission:delete-daftar-sub-standar', ['only' => ['destroy']]),
        ];
    }


    public function store(PoinRequest $request)
    {
        try {
            // Data sudah tervalidasi melalui PermissionRequest
            $data = $request->validated();
            $data['nama_poin'] = $request->nama_standar_mutu;
            $data['daftar_sub_standar_id'] = $request->id; 
            $daftarStandar = Poin::create($data);
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
            $daftarStandar = Poin::with('daftar_sub_standar.daftar_standar_mutu')->findOrFail($request->id);
        return response()->json([
            "status" => true,
            "data" => $daftarStandar,
        ]);
    }

    public function update(PoinRequest $request, $id)
    {
        try {
            $daftarStandar = Poin::findOrFail($id);
            $data['nama_poin'] = $request->nama_standar_mutu;
            $data = $request->validated();  

            $daftarStandar->update($data); 

            return response()->json([
                "status" => true,
                "data" => $daftarStandar,
                "message" => "Data Poin berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Poin tidak ditemukan",
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
            $daftarStandar = Poin::findOrFail($request->id);
            $daftarStandar->delete();
            return response()->json([
                "status" => true,
                "message" => "Data Poin berhasil dihapus"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "message" => "Data Poin tidak ditemukan",
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
