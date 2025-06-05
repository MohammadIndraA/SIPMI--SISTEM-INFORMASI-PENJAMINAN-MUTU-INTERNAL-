@extends('layouts.main')
@section('title', 'Rekap Daftar Temuan')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Rekap Daftar Temuan</li>
                    </ol>
                </div>
                <h4 class="page-title">Rekap Daftar Temuan</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless dt-responsive nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 5%; ">#</th>
                                    <th style="width: 75%; text-align: center">Program Studi</th>
                                    <th style="width: 20%; text-align: center">Jumlah Temuan</th>
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


            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('prodi.daftar-temuan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'fakultas_prodi',
                        name: 'fakultas_prodi'
                    },
                    {
                        data: 'fakultas_prodi',
                        name: 'fakultas_prodi'
                    },

                ]
            });
        });
    </script>
@endsection
