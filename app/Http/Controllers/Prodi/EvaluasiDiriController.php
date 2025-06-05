<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\FakultasProdi;
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
        $fakultas = FakultasProdi::findOrFail(auth()->user()->fakultas_id)->first();
        return view('prodi.evaluasiDiri.index', compact('fakultas'));
    }
}
