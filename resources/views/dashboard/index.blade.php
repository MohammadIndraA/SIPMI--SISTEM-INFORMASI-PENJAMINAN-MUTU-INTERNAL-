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
            <x-card-dashboard title="Program Studi" count="{{ $fakultas_prodis ?? 0 }}" />
            <x-card-dashboard title="Lembaga Akreditasi" count="{{ $lembaga_akreditasi ?? 0 }}" />
            <x-card-dashboard title="Standar Mutu" count="{{ $daftar_standar_mutu ?? 0 }}" />
            <x-card-dashboard title="Jumlah Desk Evaluation" count="{{ $poin_desk_evaluation ?? 0 }}" />
        @endrole

        @hasanyrole('Kaprodi|Prodi')
            <x-card-dashboard title="Jumlah Desk Evaluation" count="{{ $prodi_jumlah_desk_evaluation ?? 0 }}" />
            <x-card-dashboard title="Belum Desk Evaluation" count="{{ $prodi_belum_desk_evaluation ?? 0 }}" />
            <x-card-dashboard title="Sudah Desk Evaluation" count="{{ $prodi_sudah_desk_evaluation ?? 0 }}" />
        @endhasanyrole

        @hasanyrole('Auditor|Audit|LPM')
            <x-card-dashboard title="Belum Desk Evaluation" count="{{ $belum_desk_evaluation ?? 0 }}" />
            <x-card-dashboard title="Sudah Desk Evaluation" count="{{ $sudah_desk_evaluation ?? 0 }}" />
            <x-card-dashboard title="Belum Visitasi" count="{{ $belum_visitasi ?? 0 }}" />
            <x-card-dashboard title="Sudah Visitasi" count="{{ $sudah_visitasi ?? 0 }}" />
        @endhasanyrole
    </div>
    @hasanyrole('Admin')
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Monitoring</h4>
                    <div dir="ltr">
                        <div id="simple-donut-admin" class="apex-charts" data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#0acf97">
                        </div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
    @endhasanyrole
    @hasanyrole('Kaprodi|Prodi')
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Monitoring</h4>
                    <div dir="ltr">
                        <div id="simple-donut-prodi" class="apex-charts" data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#0acf97">
                        </div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
    @endhasanyrole
    @hasanyrole('Auditor|Audit|LPM')
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Monitoring</h4>
                    <div dir="ltr">
                        <div id="simple-donut-audit" class="apex-charts" data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#0acf97">
                        </div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
    @endhasanyrole
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ asset('design-sistem/assets/js/pages/demo.apex-pie.js') }}"></script>
    <script src="{{ asset('design-sistem/assets/js/vendor/apexcharts.min.js') }}"></script>

    <script>
        // Apex Donut Chart Prodi
        colors = ["#39afd1", "#ffbc00", "#313a46", "#fa5c7c", "#0acf97"];
        (dataColors = $("#simple-donut-prodi").data("colors")) &&
        (colors = dataColors.split(","));
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $prodi_sudah_desk_evaluation }},
                {{ $prodi_belum_desk_evaluation }}
            ],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: 7,
            },
            labels: ["Sudah Desk Evaluation", "Belum Desk Evaluation"],
            colors: colors,
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                },
            }, ],
        };
        (chart = new ApexCharts(
            document.querySelector("#simple-donut-prodi"),
            options
        )).render();

        // Apex Donut Chart Admin
        colors = ["#39afd1", "#ffbc00", "#313a46", "#fa5c7c", "#0acf97"];
        (dataColors = $("#simple-donut-admin").data("colors")) &&
        (colors = dataColors.split(","));
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $tidak_masuk_desk }}, {{ $sudah_desk_evaluation }},
                {{ $belum_desk_evaluation }}, {{ $sudah_visitasi }},
                {{ $belum_visitasi }}
            ],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: 7,
            },
            labels: ["Tidak Masuk desk evaluation", "Sudah Desk Evaluation", "Belum Desk Evaluation", "Sudah Visitasi",
                "Belum Visitasi"
            ],
            colors: colors,
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                },
            }, ],
        };
        (chart = new ApexCharts(
            document.querySelector("#simple-donut-admin"),
            options
        )).render();

        // Apex Donut Chart Audit
        colors = ["#39afd1", "#ffbc00", "#313a46", "#fa5c7c", "#0acf97"];
        (dataColors = $("#simple-donut-audit").data("colors")) &&
        (colors = dataColors.split(","));
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $sudah_desk_evaluation }},
                {{ $belum_desk_evaluation }}, {{ $sudah_visitasi }},
                {{ $belum_visitasi }}
            ],
            legend: {
                show: !0,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: 7,
            },
            labels: ["Sudah Desk Evaluation", "Belum Desk Evaluation", "Sudah Visitasi",
                "Belum Visitasi"
            ],
            colors: colors,
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: !1
                    }
                },
            }, ],
        };
        (chart = new ApexCharts(
            document.querySelector("#simple-donut-audit"),
            options
        )).render();
    </script>
@endsection
