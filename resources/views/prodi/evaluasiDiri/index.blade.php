@extends('layouts.main')
@section('title', 'Evalusi Diri')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('prodi.evalusi-diri.index') }}"
                                style="color: darkgrey ; text-decoration: none">Evalusi Diri</a>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Evalusi Diri</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @php
                        $tanggalSaatIni = \Carbon\Carbon::today();
                    @endphp
                    @if ($tanggalSaatIni->between($periode->awal_periode_evaluasi_diri, $periode->akhir_periode_evaluasi_diri))
                        <div class="row mb-4">
                            <div class="alert alert-info" role="alert">
                                <i class="dripicons-information me-2"></i> Silahkan Pilih Lembaga Akreditasi Untuk
                                Menampilkan
                                Standar Mutu
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-md-2">
                                <div class="row mb-1">
                                    <div class="col-sm-2 col-md-2 px-1 h-50 p-4 ps-3">
                                        <!-- Link with Dropdown -->
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Pilih Program Studi
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                @if (request()->is('*rekap-desk-evaluasi*'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('prodi.standar-mutu-rekap-desk-evaluasi.index', ['fakultas' => $fakultas->slug]) }}">
                                                        {{ $fakultas->fakultas_prodi }}
                                                    </a>
                                                @else
                                                    <a class="dropdown-item"
                                                        href="{{ route('prodi.standar-mutu.index', ['fakultas' => $fakultas->slug]) }}">{{ $fakultas->fakultas_prodi }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row mb-1">
                                    <div class="col-sm-4 col-md-10 px-1 h-50">
                                        <!-- Link with Dropdown -->
                                        <h3 style="color: royalblue">SPMI</h3>
                                        <p style="color: gray">Standar Nasional : Standar Nasional Pendidikan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mb-1">
                            <div class="alert alert-warning" role="alert">
                                <i class="dripicons-information me-2"></i>
                                @if ($tanggalSaatIni < $periode->awal_periode_evaluasi_diri)
                                    Masa Evaluasi Diri Belum Dimulai
                                @elseif ($tanggalSaatIni > $periode->akhir_periode_evaluasi_diri)
                                    Masa Evaluasi Diri Telah Berakhir
                                @endif
                            </div>
                        </div>
                    @endif
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')
