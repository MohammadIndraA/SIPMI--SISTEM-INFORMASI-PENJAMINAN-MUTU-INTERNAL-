<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Models\KategoriDokumen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class SubStandarController extends Controller
{
       public static function middleware()
    {
        return [
            new Middleware('permission:view-sub-standar', ['only' => ['index','show']]),
        ];
    }
      public function index(Request $request)
    {
        $kategori_dokumens = KategoriDokumen::all();
        return view('prodi.subStandar.index', compact('kategori_dokumens'));
    }
}
