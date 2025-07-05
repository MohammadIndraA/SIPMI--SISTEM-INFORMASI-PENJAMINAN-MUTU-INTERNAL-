@extends('layouts.main')
@section('title', 'Daftar Standar Mutu')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('auditor.standar-mutu.index', ['fakultas' => request()->segment(3)]) }}"
                                style="color: darkgrey ; text-decoration: none">Standar Mutu</a>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title"> Evaluasi Diri</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <h4 class="page-title"> Daftar Standar Mutu</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100" id="data-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th class="text-center" width="90%" style="width: 90% !important;">Standar Mutu
                                    </th>
                                    {{-- <th style="width: 85px;">Action</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function() {

            // ajax setup for csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url;
            let path = window.location
                .pathname; // Contoh: "/prodi/standar-mutu/rekap-desk-evaluasi/fakultas-informatika"

            if (path.includes('visitasi')) {
                url =
                    "{{ route('auditor.standar-mutu-visitasi.index', ['fakultas' => request()->segment(3)]) }}";
            } else {
                url = "{{ route('auditor.standar-mutu.index', ['fakultas' => request()->segment(3)]) }}";
            }
            console.log(url);


            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_standar_mutu',
                        name: 'nama_standar_mutu',
                        searchable: true,
                        sortable: false
                    },
                ],
            });

            // Event Handlers
            $('#filter_periode').on('change', function() {
                var table = $('#data-table').DataTable();
                table.ajax.reload();
            });

            $('#filter_lembaga').on('change', function() {
                var table = $('#data-table').DataTable();
                table.ajax.reload();
            })
        });
    </script>
@endsection
