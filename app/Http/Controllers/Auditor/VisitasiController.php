<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\FakultasProdi;
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
        return view('auditor.visitasi.index', compact('standar_nasionals', 'fakultas_prodis'));
    }
}
