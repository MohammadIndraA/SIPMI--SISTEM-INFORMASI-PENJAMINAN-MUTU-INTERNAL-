@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Pengaturan Periode</li>
                    </ol>
                </div>
                <h4 class="page-title">Pengaturan Periode</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('view-pengaturan-periode')
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('pengaturan-periode.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>
                                    Add Pengaturan Periode</a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless dt-responsive nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Periode</th>
                                    <th>Lembaga Akreditasi</th>
                                    <th>Periode Evaluasi Diri</th>
                                    <th>Periode Desk Evaluasi</th>
                                    <th>Periode Visitasi</th>
                                    <th style="width: 20px" class="text-center"><i class="dripicons-gear"></i></th>
                                    {{-- <th style="width: 85px;">Action</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <x-modal>
        <div class="modal-body">
            <x-slot name="size">
                modal-lg
            </x-slot>
            <div class="row mb-1">
                <label for="tahun_periode_id" class="col-3 col-form-label">Tahun <sop class="text-danger">*
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select form-select-sm mb-1" id="tahun_periode_id" style="width: 30%"
                        name="tahun_periode_id">
                        @foreach ($tahunPeriodes as $item)
                            <option value="{{ $item->id }}">{{ $item->tahun_periode }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <label for="lembaga_akreditasi_id" class="col-3 col-form-label">Standar Akreditasi <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select form-select-sm mb-1" id="lembaga_akreditasi_id" name="lembaga_akreditasi_id">
                        @foreach ($lembagaAkreditasis as $item)
                            <option value="{{ $item->id }}">{{ $item->lembaga_akreditasi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <label for="standar_nasional_id" class="col-3 col-form-label">Standar Nasional <sop class="text-danger">*
                    </sop>
                </label>
                <div class="col-9">
                    <div class="form-check">
                        @foreach ($standarNasionals as $item)
                            <label class="form-check-label" for="standar-{{ $item->id }}"><input type="checkbox"
                                    class="form-check-input" id="standar-{{ $item->id }}" value="{{ $item->id }}"
                                    name="standar_nasional_id[]">
                                {{ $item->standar_nasional }}</label><br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mb-1 mt-2">
                <label for="awal_periode_evaluasi_diri" class="col-3 col-form-label">
                    Periode Evaluasi Diri <span class="text-danger">*</span>
                </label>
                <div class="col-9">
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="awal_periode_evaluasi_diri"
                                name="awal_periode_evaluasi_diri" placeholder="yyy/mm/dd">
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <span>s/d</span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="akhir_periode_evaluasi_diri"
                                name="akhir_periode_evaluasi_diri" data-date-container="#datepicker2"
                                placeholder="yyy/mm/dd">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-1 mt-2">
                <label for="awal_periode_desk_evaluasi" class="col-3 col-form-label">
                    Periode Desk Evaluasi <span class="text-danger">*</span>
                </label>
                <div class="col-9">
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="awal_periode_desk_evaluasi"
                                name="awal_periode_desk_evaluasi" placeholder="yyy/mm/dd">
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <span>s/d</span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="akhir_periode_desk_evaluasi"
                                name="akhir_periode_desk_evaluasi" data-date-container="#datepicker2"
                                placeholder="yyy/mm/dd">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-1 mt-2">
                <label for="awal_periode_visitasi" class="col-3 col-form-label">
                    Periode Visitasi <span class="text-danger">*</span>
                </label>
                <div class="col-9">
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" id="awal_periode_visitasi"
                                name="awal_periode_visitasi" placeholder="yyy/mm/dd">
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <span>s/d</span>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="akhir_periode_visitasi"
                                name="akhir_periode_visitasi" placeholder="yyy/mm/dd">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </x-modal>
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
                ajax: "{{ route('pengaturan-periode.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tahun_periode_id',
                        name: 'tahun_periode_id',
                        render: function(data, type, row) {
                            return row.tahun_periode.tahun_periode;
                        }
                    },
                    {
                        data: 'lembaga_akreditasi_id',
                        name: 'lembaga_akreditasi_id',
                        render: function(data, type, row) {
                            return row.lembaga_akreditasi.lembaga_akreditasi;
                        }
                    },
                    {
                        data: 'awal_periode_evaluasi_diri',
                        name: 'awal_periode_evaluasi_diri',
                        render: function(data, type, row) {
                            return row.awal_periode_evaluasi_diri + ' s/d ' + row
                                .akhir_periode_evaluasi_diri;
                        }
                    },
                    {
                        data: 'awal_periode_desk_evaluasi',
                        name: 'awal_periode_desk_evaluasi',
                        render: function(data, type, row) {
                            return row.awal_periode_desk_evaluasi + ' s/d ' + row
                                .akhir_periode_desk_evaluasi;
                        }
                    },
                    {
                        data: 'awal_periode_visitasi',
                        name: 'awal_periode_visitasi',
                        render: function(data, type, row) {
                            return row.awal_periode_visitasi + ' s/d ' + row
                                .akhir_periode_visitasi;
                        }
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    }

                ]
            });

        });


        // trigger add modal
        function addUser(url) {
            $('#myForm').attr('action', url);
            $('#myForm').data('type', 'add');
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Tambah Data Pengaturan Periode");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Edit Data Pengaturan Periode");
            $('#modal-form').modal('show');
            // url action to update
            let url = `{{ route('pengaturan-periode.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('pengaturan-periode.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Pengaturan Periode");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#tahun_periode_id').val(res.data.tahun_periode.id);
                    $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                    $('#awal_periode_evaluasi_diri').val(res.data.awal_periode_evaluasi_diri);
                    $('#akhir_periode_evaluasi_diri').val(res.data.akhir_periode_evaluasi_diri);
                    $('#awal_periode_desk_evaluasi').val(res.data.awal_periode_desk_evaluasi);
                    $('#akhir_periode_desk_evaluasi').val(res.data.akhir_periode_desk_evaluasi);
                    $('#awal_periode_visitasi').val(res.data.awal_periode_visitasi);
                    $('#akhir_periode_visitasi').val(res.data.akhir_periode_visitasi);
                    res.data.standar_nasionals.forEach(element => {
                        $('#standar-' + element.id).prop('checked', true);
                    });
                },
                error: function(data) {
                    console.log(data.errors);

                    alertNotify('error', data.responseJSON.message);
                }
            });
        }

        // trigger delete
        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;

                // ajax
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('pengaturan-periode.delete') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        alertNotify('success', data.message);
                        var oTable = $('#data-table').dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        alertNotify('error', data.responseJSON.message);
                    }
                });
            }
        }

        // submit form with ajax
        $('#myForm').submit(function(e) {
            $("#btnSave").html(`
            <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                     </div> Loading...
            `);
            $("#btnSave").attr("disabled", true);
            e.preventDefault();
            var formData = new FormData(this);

            if ($('#myForm').data('type') == 'edit') {
                formData.append('_method', 'PUT')
            }
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#modal-form").modal('hide');
                    var oTable = $('#data-table').dataTable();
                    oTable.fnDraw(false);
                    $("#btnSave").html("Simpan");
                    $("#btnSave").attr("disabled", false);
                    alertNotify('success', data.message);
                },
                error: function(data) {
                    $("#btnSave").html("Simpan");
                    $("#btnSave").attr("disabled", false);
                    loopErrors(data.responseJSON.errors);
                    alertNotify('danger', data.responseJSON.message);
                }
            });
        });

        $('#akhir_periode_visitasi, #awal_periode_visitasi, #akhir_periode_evaluasi_diri, #awal_periode_evaluasi_diri, #akhir_periode_desk_evaluasi, #awal_periode_desk_evaluasi')
            .flatpickr({
                dateFormat: 'Y-m-d'
            });
    </script>
@endsection
