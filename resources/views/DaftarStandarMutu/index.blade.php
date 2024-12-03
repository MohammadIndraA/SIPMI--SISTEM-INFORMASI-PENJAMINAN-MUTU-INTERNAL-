@extends('layouts.main')
@section('style')
    <!-- Quill css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">

@endsection
@section('title', 'Daftar Standar Mutu')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active"> Daftar Standar Mutu</li>
                    </ol>
                </div>
                <h4 class="page-title"> Daftar Standar Mutu</h4>
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
                        @can('view-daftar-standar-mutu')
                            <div class="col-sm-4 col-md-3 d-flex justify-content-end text-end item-button h-50 pt-2">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('daftar-standar-mutu.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>Tambah Daftar Standar Mutu</a>
                            </div>
                        @endcan
                    </div>


                    <div class="table-responsive">
                        <table class="table table-borderless nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Standar Mutu</th>
                                    <th>Indikator</th>
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
            <input type="hidden" name="id" id="id">
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
                <label for="nama_standar_mutu" class="col-3 col-form-label">
                    Nama Standar Mutu <span class="text-danger">*</span>
                </label>
                <div class="col-9">
                    <textarea class="summernote" name="nama_standar_mutu" id="nama_standar_mutu"></textarea>
                </div>
            </div>
            <div class="row mb-1 standar d-none">
                <label for="kategori" class="col-3 col-form-label">Standar Akreditasi <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="kategori" name="kategori">
                        <option value="Standar">Standar</option>
                        <option value="Sub Standar">Sub Standar</option>
                    </select>
                </div>
            </div>
            <div class="row mb-1 sub-standar d-none">
                <label for="jenjang" class="col-3 col-form-label">Jenjang <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="jenjang" name="jenjang">
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <label for="deskripsi" class="col-3 col-form-label">Deskripsi
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="-"
                        rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-1 sub-standar d-none">
                <label for="jenis_perhitungan" class="col-3 col-form-label">Jenis Prhitungan <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="jenis_perhitungan" name="jenis_perhitungan">
                        <option value="Manual">Manual</option>
                    </select>
                </div>
            </div>
            <div class="row mb-1 sub-standar d-none">
                <label for="isian_rumus" class="col-3 col-form-label">Isian Rumus <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="isian_rumus" name="isian_rumus">
                        <option value="IPK">IPK</option>
                        <option value="IPS">IPS</option>
                    </select>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- panggil form standar --}}
    @includeIf('includes.summernote')
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

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
                    url: "{{ route('daftar-standar-mutu.index') }}",
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
                        data: 'nama_standar_mutu',
                        name: 'nama_standar_mutu',
                    },
                    {
                        data: 'indikator',
                        name: 'indikator',
                        searchable: false,
                        render: function(data, type, row) {
                            return data ?? 0;
                        }
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
            })

            // summernote
            $('.summernote').summernote({
                placeholder: 'Hello stand alone ui',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
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
            $('#modal-title').text("Tambah Data Daftar Daftar Mutu");
            $('#modal-form').modal('show');
            $("#lembaga_akreditasi_id").attr("disabled", false);
            $("#tahun_periode_id").attr("disabled", false);
            $(".standar").addClass("d-none").fadeOut();
            $(".sub-standar").addClass("d-none").fadeOut();
            $('#myForm').find('.summernote').summernote('code', '');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Edit Data Daftar Daftar Mutu");
            $('#modal-form').modal('show');
            $("#lembaga_akreditasi_id").attr("disabled", false);
            $("#tahun_periode_id").attr("disabled", false);
            $(".standar").addClass("d-none").fadeOut();
            $(".sub-standar").addClass("d-none").fadeOut();
            // url action to update
            let url = `{{ route('daftar-standar-mutu.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('daftar-standar-mutu.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Daftar Daftar Mutu");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                    $('#tahun_periode_id').val(res.data.tahun_periode_id);
                    $('#deskripsi').val(res.data.deskripsi);
                    $('#myForm').find('.summernote').summernote('code', res.data.nama_standar_mutu);
                },
                error: function(data) {
                    console.log(data.errors);

                    alertNotify('error', data.responseJSON.message);
                }
            });
        }
        // trigger tambah sub standar
        function addStandar(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Tambah Data Standar");
            $('#modal-form-standar').modal('show');
            $('#myForm').find('.summernote').summernote('code', '');
            // Deklarasi variabel url di luar blok if-else
            let url;
            if ($('#kategori').val() == 'Standar') {
                url = `{{ route('daftar-standar.store') }}`
            } else {
                url = `{{ route('daftar-sub-standar.store') }}`
            }
            $('#myForm').attr('action', url);
            $('#myForm').attr('method', 'POST');
            $("#lembaga_akreditasi_id").attr("disabled", true);
            $("#tahun_periode_id").attr("disabled", true);
            $(".standar").removeClass("d-none").fadeIn();

            $.ajax({
                type: "GET",
                url: "{{ route('daftar-standar-mutu.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Standar");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                    $('#tahun_periode_id').val(res.data.tahun_periode_id);
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
                    url: "{{ route('daftar-standar-mutu.delete') }}",
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
            if ($('#kategori').val() == 'Sub Standar') {
                formData.append('nama_sub_standar', $('[name="nama_standar_mutu"]').val());
            }
            if ($('#kategori').val() == 'Standar') {
                formData.append('nama_standar', $('[name="nama_standar_mutu"]').val());
            }
            // formData.append('nama_standar_mutu', $('[name="nama_standar_mutu"]').val());
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

        $('#kategori').on('change', function() {
            if ($(this).val() == 'Sub Standar') {
                $(".sub-standar").removeClass("d-none").fadeIn();
                $('#myForm').attr('action', `{{ route('daftar-sub-standar.store') }}`);
            } else {
                $(".sub-standar").addClass("d-none").fadeOut();
            }
        });
    </script>
@endsection
