<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndikatorRequest;
use App\Models\Indikator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndikatorController extends Controller
 {
            public function store(IndikatorRequest $request)
            {
                DB::beginTransaction();

                try {
                    $validatedData = $request->validated();
                    $validatedData['poin_id'] = $request->poin_id;

                    // Tetap menggunakan updateOrCreate tapi dengan optimasi
                    $indikator = Indikator::updateOrCreate(
                        ['id' => $request->id ?? null],
                        $validatedData
                    );

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'data' => $indikator,
                        'message' => $indikator->wasRecentlyCreated 
                            ? 'Data Indikator Prodi berhasil ditambahkan'
                            : 'Data Indikator Prodi berhasil diperbarui'
                    ], 200);

                } catch (\Exception $e) {
                    DB::rollBack();

                    Log::error('Indikator Store Error: '.$e->getMessage(), [
                        'request' => $request->all(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan sistem',
                        'error' => config('app.debug') ? $e->getMessage() : null
                    ], 500);
                }
            }

      public function edit(Request $request)
        {
            $indikator = Indikator::where('poin_id', $request->id)->first();
        return response()->json([
            "status" => true,
            "data" => $indikator,
        ]);
    }

    public function update(indikatorRequest $request, $id)
    {
        try {
            $indikator = Indikator::findOrFail($id);
            $data = $request->validated();  

            $indikator->update($data); 

            return response()->json([
                "status" => true,
                "data" => $indikator,
                "message" => "Data Indikator Prodi berhasil diupdate"
            ], 200); // HTTP Status 200 untuk sukses
        } catch (ModelNotFoundException $e) {
            // Jika user dengan ID tersebut tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "Data Indikator Prodi tidak ditemukan",
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
}
