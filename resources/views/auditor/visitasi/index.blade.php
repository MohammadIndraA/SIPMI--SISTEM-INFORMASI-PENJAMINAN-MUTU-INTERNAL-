@extends('layouts.main')
@section('title', 'Visitasi')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('auditor.visitasi.index') }}"
                                style="color: darkgrey ; text-decoration: none">Visitasi</a>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Visitasi</h4>
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
                    @if ($tanggalSaatIni->between($periode->awal_periode_visitasi, $periode->akhir_periode_visitasi))
                        <div class="row mb-3">
                            <div class="alert alert-info" role="alert">
                                <i class="dripicons-information me-2"></i> Silahkan Pilih Lembaga Akreditasi Untuk
                                Menampilkan
                                Standar Mutu
                            </div>
                        </div>
                        <div class="row ms-2">
                            <div class="mb-2"> <strong><b>
                                        <h5>Lembaga Akreditasi</h5>
                                    </b></strong></div>
                            <hr>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 col-md-10 px-1 h-50">
                                        <!-- Link with Dropdown -->
                                        <h3 style="color: royalblue">SPMI</h3>
                                        <p style="color: gray">Standar Nasional : @foreach ($standar_nasionals as $item)
                                                {{ $item->standar_nasional }} ,
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <div class="">
                                    @foreach ($fakultas_prodis as $item)
                                        <a href="{{ route('auditor.standar-mutu-visitasi.index', ['fakultas' => $item->slug]) }}"
                                            class="btn btn-primary btn-sm"><span>{{ $item->fakultas_prodi }}</span> <i
                                                class="mdi mdi-arrow-right ms-1"></i> </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-1">
                            <div class="alert alert-warning" role="alert">
                                <i class="dripicons-information me-2"></i>
                                @if ($tanggalSaatIni < $periode->awal_periode_visitasi)
                                    Masa Desk Evaluation Belum Dimulai
                                @elseif ($tanggalSaatIni > $periode->akhir_periode_visitasi)
                                    Masa Desk Evaluation Telah Berakhir
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
