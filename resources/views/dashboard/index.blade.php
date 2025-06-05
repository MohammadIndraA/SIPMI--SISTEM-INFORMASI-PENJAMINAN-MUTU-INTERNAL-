@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <h4 class="page-title">Dashboard</h4>
    </div>
    <!-- end page title -->

    <div class="row">

        @role('Admin')
            <x-card-dashboard title="Program Studi" count="{{ $fakultas_prodis }}" />
            <x-card-dashboard title="Lembaga Akreditasi" count="{{ $lembaga_akreditasi }}" />
            <x-card-dashboard title="Standar Mutu" count="{{ $daftar_standar_mutu }}" />
        @endrole

        @hasanyrole('Kaprodi|Prodi')
            <x-card-dashboard title="Target Nilai Mutu Program Studi" count="0" />
            <x-card-dashboard title="Nilai Evaluasi Diri Program Studi" count="0" />
            <x-card-dashboard title="Nilai Hasil Program Studi" count="0" />
        @endhasanyrole

        @hasanyrole('Auditor|Audit|LPM')
            <x-card-dashboard title="Belum Desk Evaluation" count="0" />
            <x-card-dashboard title="Sudah Desk Evaluation" count="0" />
            <x-card-dashboard title="Belum Visitasi" count="0" />
            <x-card-dashboard title="Sudah Visitasi" count="0" />
        @endhasanyrole
    </div>
    <!-- end row -->
@endsection
