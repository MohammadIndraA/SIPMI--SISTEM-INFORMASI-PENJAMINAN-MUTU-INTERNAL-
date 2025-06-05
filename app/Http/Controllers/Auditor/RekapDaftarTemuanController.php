<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class RekapDaftarTemuanController extends Controller
{    

    public static function middleware()
    {
        return [
            new Middleware('permission:view-rekap-daftar-temuan', ['only' => ['index','show']]),
        ];
    }
    
    public function index()
    {
        return view('auditor.rekapDaftarTemuan.index');
    }
}
