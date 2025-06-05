@extends('layouts.main')
@section('title', 'Desk Evaluation')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('auditor.desk-evaluations.index') }}"
                                style="color: darkgrey ; text-decoration: none">Desk Evaluation</a>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Desk Evaluation</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="alert alert-info" role="alert">
                            <i class="dripicons-information me-2"></i> Silahkan Pilih Lembaga Akreditasi Untuk Menampilkan
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
                                    <a href="#"
                                        class="btn btn-primary btn-sm"><span>{{ $item->fakultas_prodi }}</span> <i
                                            class="mdi mdi-arrow-right ms-1"></i> </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')
