@extends('layouts.main')
@section('title', 'Daftar Temuan')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Daftar Temuan</li>
                    </ol>
                </div>
                <h4 class="page-title">Daftar Temuan</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-9">
                            <div class="row mb-1">
                                <div class="col-sm-2 col-md-1 px-1">
                                    <strong>Filter</strong>
                                </div>
                                <div class="col-sm-2 col-md-4 px-1">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-2 col-md-2 px-1">
                                    <b>Tahun</b>
                                </div>
                                <div class="col-sm-2 col-md-3 px-1">
                                    <select class="form-control select2" name="filter_periode" id="filter_periode"
                                        data-toggle="select2">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($tahunPeriodes as $item)
                                            <option value="{{ $item->id }}">{{ $item->tahun_periode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-2 col-md-2 px-1 text-button">
                                    <b>Lembaga Akreditasi</b>
                                </div>
                                <div class="col-sm-2 col-md-3 px-1">
                                    <select class="form-control select2" name="filter_lembaga" id="filter_lembaga"
                                        data-toggle="select2">
                                        <option value="">Semua Lembaga</option>
                                        @foreach ($lembagaAkreditasis as $item)
                                            <option value="{{ $item->id }}">{{ $item->lembaga_akreditasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th width="40%">Program Studi</th>
                                    <th>Jumlah Temuan</th>
                                    <th>Jumlah Temuan Disetujui</th>
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
                ajax: {
                    url: "{{ route('daftar-temuan.index') }}",
                    data: function(d) {
                        d.tahun_periode_id = $('#filter_periode').val();
                        d.lembaga_akreditasi_id = $('#filter_lembaga').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'fakultas_prodi',
                        name: 'fakultas_prodi',
                    },
                    {
                        data: 'total_temuan',
                        name: 'total_temuan',
                        render: function(data, type, row) {
                            var temuan = "";
                            if (row.total_temuan == 0) {
                                temuan = '<span class="text-success">Tidak Ada Temuan</span>';
                            } else {
                                temuan = "<span class='text-danger'>Ada " + row.total_temuan +
                                    " Temuan</span>";
                            }
                            return temuan;
                        }
                    },
                    {
                        data: 'total_temuan_disetujui',
                        name: 'total_temuan_disetujui',
                        render: function(data, type, row) {
                            var temuan = "";
                            if (row.total_temuan_disetujui == 0) {
                                temuan = 'Tidak Ada Temuan Disetujui';
                            } else {
                                temuan = "<span class='text-success'> " + row
                                    .total_temuan_disetujui + " Temuan Disetujui</span>";
                            }
                            return temuan;
                        }
                    },

                ]
            });

            // Event Handlers
            $('#filter_periode').on('change', function() {
                var table = $('#data-table').DataTable();
                table.ajax.reload();
            });

            $('#filter_lembaga').on('change', function() {
                var table = $('#data-table').DataTable();
                table.ajax.reload();
            });
        });
    </script>
@endsection
