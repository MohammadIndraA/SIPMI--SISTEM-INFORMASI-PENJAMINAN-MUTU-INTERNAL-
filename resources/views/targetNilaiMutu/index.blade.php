@extends('layouts.main')
@section('title', 'Target Nilai Mutu')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Target Nilai Mutu</li>
                    </ol>
                </div>
                <h4 class="page-title">Target Nilai Mutu</h4>
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
                        @can('view-target-nilai-mutu')
                            <div class="col-sm-4 col-md-3 d-flex justify-content-end text-end item-button h-50 pt-2">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('target-nilai-mutu.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>Tambah Target Nilai Mutu</a>
                            </div>
                        @endcan
                    </div>



                    <div class="table-responsive">
                        <table class="table table-borderless nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Program Studi</th>
                                    <th>Tahun</th>
                                    <th>Lembaga Akreditasi</th>
                                    <th>Target Nilai</th>
                                    <th>Keterengan</th>
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
                <label for="fakultas_prodi_id" class="col-3 col-form-label">Program Studi <sop class="text-danger">*
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select form-select-sm mb-1" id="fakultas_prodi_id" name="fakultas_prodi_id">
                        @foreach ($fakultasProdies as $item)
                            <option value="{{ $item->id }}">{{ $item->fakultas_prodi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <label for="tahun_periode_id" class="col-3 col-form-label">Tahun <sop class="text-danger">*
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select form-select-sm mb-1" id="tahun_periode_id" name="tahun_periode_id">
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
                <label for="target_nilai_mutu" class="col-3 col-form-label">Target Nilai <sop class="text-danger">*</sop>
                </label>
                <div class="col-9">
                    <input type="text" class="form-control" name="target_nilai_mutu" id="target_nilai_mutu"
                        value="{{ old('target_nilai_mutu') }}" placeholder="4.0">
                </div>
            </div>
            <div class="row mb-1">
                <label for="keterangan" class="col-3 col-form-label">keterangan
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="-"
                        rows="4"></textarea>
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
                ajax: {
                    url: "{{ route('target-nilai-mutu.index') }}",
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
                        data: 'fakultas_prodi_id',
                        name: 'fakultas_prodi_id',
                        render: function(data, type, row) {
                            return row.fakultas_prodi.fakultas_prodi;
                        }
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
                        data: 'target_nilai_mutu',
                        name: 'target_nilai_mutu',
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    }

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


        // trigger add modal
        function addUser(url) {
            $('#myForm').attr('action', url);
            $('#myForm').data('type', 'add');
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Tambah Data Target Nilai Mutu");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Edit Data Target Nilai Mutu");
            $('#modal-form').modal('show');
            // url action to update
            let url = `{{ route('target-nilai-mutu.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('target-nilai-mutu.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Target Nilai Mutu");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#tahun_periode_id').val(res.data.tahun_periode.id);
                    $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                    $('#fakultas_prodi_id').val(res.data.fakultas_prodi_id);
                    $('#target_nilai_mutu').val(res.data.target_nilai_mutu);
                    $('#keterangan').val(res.data.keterangan);
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
                    url: "{{ route('target-nilai-mutu.delete') }}",
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
    </script>
@endsection
