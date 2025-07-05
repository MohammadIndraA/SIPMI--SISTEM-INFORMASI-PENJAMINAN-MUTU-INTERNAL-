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
                        <table class="table w-100" id="data-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center" width="80%" style="width: 90% !important;">Standar Mutu
                                    </th>
                                    <th style="width: 10px;" class="text-center"><i class="dripicons-gear"></i></th>
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
            <input type="hidden" name="daftar_standar_mutu_id" id="daftar_standar_mutu_id">
            <input type="hidden" name="daftar_standar_id" id="daftar_standar_id">
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
                        <option selected disabled>-- Pilih Kategori --</option>
                        <option value="Standar" id="standar">Standar</option>
                        <option value="Sub Standar" id="sub_standar">Sub Standar</option>
                        <option value="Poin" id="poin">Poin</option>
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
            <div class="row mb-1" hidden id="wrap_jenis_perhitungan">
                <label for="jenis_perhitungan" class="col-3 col-form-label">Jenis Perhitungan <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="jenis_perhitungan" name="jenis_perhitungan">
                        <option value="Manual">Manual</option>
                    </select>
                </div>
            </div>
            <div class="row mb-1" hidden id="wrap_isian_rumus">
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
            <div class="row mb-1 sub-standar d-none">
                <label for="isian_rumus" class="col-3 col-form-label">Prodi<sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <div class="form-check form-check-inline">
                        @foreach ($prodis as $item)
                            <label class="form-check-label mx-3 my-1" for="prodi-{{ $item->id }}"> <input
                                    type="checkbox" name="prodi[]" class="form-check-input form-check-lg"
                                    id="prodi-{{ $item->id }}" value="{{ $item->id }}"
                                    {{ old('prodi.' . $loop->index) ? 'checked' : '' }}>
                                {{ $item->fakultas_prodi }}</label>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- modal indikator --}}
    <x-modal-indikator>
    </x-modal-indikator>


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
                    // {
                    //     data: 'indikator',
                    //     name: 'indikator',
                    //     searchable: false,
                    //     render: function(data, type, row) {
                    //         return data ?? 0;
                    //     }
                    // },
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
        function editFunc(id, type) {
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
            let url = `{{ route('daftar-standar-mutu.update', 'id') }}`;
            let urlEdit = `{{ route('daftar-standar-mutu.edit') }}`;
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: urlEdit,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res.data);

                    $('#modal-title').html("Edit Data Daftar Daftar Mutu");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    if (res.data.lembaga_akreditasi_id == null) {
                        $('#lembaga_akreditasi_id').val(res.data.daftar_standar_mutu.lembaga_akreditasi_id);
                        $('#tahun_periode_id').val(res.data.daftar_standar_mutu.tahun_periode_id);
                        $('#myForm').find('.summernote').summernote('code', res.data.nama_standar);
                    }
                    if (res.data.nama_sub_standar != null) {
                        $('#lembaga_akreditasi_id').val(res.data.daftar_standar_mutu.lembaga_akreditasi_id);
                        $('#tahun_periode_id').val(res.data.daftar_standar_mutu.tahun_periode_id);
                        $('#myForm').find('.summernote').summernote('code', res.data.nama_sub_standar);
                        $('#kategori').val('Sub Standar');
                        $('#jenjang').val(res.data.jenjang);
                        $('#isian_rumus').val(res.data.isian_rumus);
                        $('#jenis_perhitungan').val(res.data.jenis_perhitungan);
                    }
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

        $('#btnClose').on('click', function() {
            $('#myForm').trigger("reset"); // Mereset form
            $('#kategori').val(''); // Mereset nilai select ke default (opsional)
            $('#kategori option').show(); // Menampilkan semua opsi yang sebelumnya disembunyikan
            $(".standar").addClass("d-none").fadeOut();
            $(".sub-standar").addClass("d-none").fadeOut();
        });
        // trigger tambah sub standar
        function addStandar(id, type) {
            $('#myForm').trigger("reset");
            $('#myForm').data('type', 'add');
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Tambah Data Standar");
            $('#modal-form-standar').modal('show');
            $('#myForm').find('.summernote').summernote('code', '');
            $('#kategori').prop('disabled', false); // Menonaktifkan elemen <select>

            // cek jika standar
            if (type == 'daftar-standar-mutu') {
                $('#sub_standar').hide();
                $('#poin').hide();
            } else if (type == 'daftar-standar') {
                $('#standar').hide();
                $('#poin').hide();
                $('#wrap_isian_rumus').hide();
                $('#wrap_jenis_perhitungan').hide();
            } else if (type == 'daftar-sub-standar') {
                $('#standar').hide();
                $('#sub_standar').hide();
                $('#wrap_isian_rumus').hide();
                $('#wrap_jenis_perhitungan').hide();
            }
            // Deklarasi variabel url di luar blok if-else
            let url;
            const kategori = $('#kategori').val(); // Ambil nilai dari #kategori

            $("#lembaga_akreditasi_id").attr("disabled", true);
            $("#tahun_periode_id").attr("disabled", true);
            $(".standar").removeClass("d-none").fadeIn();

            let urlEdit;
            if (type == 'daftar-standar-mutu') {
                urlEdit = `{{ route('daftar-standar-mutu.edit') }}`
            } else if (type == 'daftar-standar') {
                urlEdit = `{{ route('daftar-standar.edit') }}`
            } else {
                urlEdit = `{{ route('daftar-sub-standar.edit') }}`
            }

            $.ajax({
                type: "GET",
                url: urlEdit,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res.data);
                    $('#modal-title').html("Tambah Data");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#daftar_standar_mutu_id').val(res.data.daftar_standar_mutu_id);
                    $('#daftar_standar_id').val(res.data.daftar_standar_id);
                    if (res.data.nama_standar_mutu != null) {
                        if (res.data.nama_standar_mutu != null) {
                            $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                            $('#tahun_periode_id').val(res.data.tahun_periode_id);
                        }
                        if (res.data.nama_standar != null) {
                            $('#tahun_periode_id').val(res.data.daftar_standar_mutu.tahun_periode_id);
                        }
                    }
                },
                error: function(data) {
                    console.log(data.errors);

                    alertNotify('error', data.responseJSON.message);
                }
            });
        }

        // edit standar dan sub standar
        function editStandar(id, type) {
            $('#myForm').trigger("reset");
            $('#myForm')[0].reset();
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-form-standar').modal('show');
            $('#modal-title').text("Edit Data Daftar Mutu");
            $("#lembaga_akreditasi_id").attr("disabled", true);
            $("#tahun_periode_id").attr("disabled", true);
            $(".standar").removeClass("d-none").fadeIn();
            $('#kategori').prop('disabled', true); // Menonaktifkan elemen <select>
            // url action to update
            let url = "";
            let urlEdit = "";
            if (type == 'daftar-standar-mutu') {
                urlEdit = `{{ route('daftar-standar-mutu.edit') }}`
                url = `{{ route('daftar-standar-mutu.update', 'id') }}`
            } else if (type == 'daftar-standar') {
                urlEdit = `{{ route('daftar-standar.edit') }}`
                url = `{{ route('daftar-standar.update', 'id') }}`
            } else if (type == 'daftar-sub-standar') {
                urlEdit = `{{ route('daftar-sub-standar.edit') }}`
                url = `{{ route('daftar-sub-standar.update', 'id') }}`
            } else if (type == "poin") {
                urlEdit = `{{ route('poin.edit') }}`
                url = `{{ route('poin.update', 'id') }}`
            }
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: urlEdit,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Daftar Mutu");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    // standar
                    if (res.data.nama_standar != null) {
                        $('#lembaga_akreditasi_id').val(res.data.daftar_standar_mutu.lembaga_akreditasi_id);
                        $('#tahun_periode_id').val(res.data.daftar_standar_mutu.tahun_periode_id);
                        $('#myForm').find('.summernote').summernote('code', res.data.nama_standar);
                        $('#kategori').val('Standar');
                    }
                    // sub standar
                    $('#daftar_standar_mutu_id').val(res.data.daftar_standar_mutu_id);
                    if (res.data.nama_sub_standar != null) {
                        $('#lembaga_akreditasi_id').val(res.data.daftar_standar_mutu.lembaga_akreditasi_id);
                        $('#tahun_periode_id').val(res.data.daftar_standar_mutu.tahun_periode_id);
                        $('#myForm').find('.summernote').summernote('code', res.data.nama_sub_standar);
                        $('#kategori').val('Sub Standar');
                        $('#jenjang').val(res.data.jenjang);
                        $('#isian_rumus').val(res.data.isian_rumus);
                        $('#jenis_perhitungan').val(res.data.jenis_perhitungan);
                        $(".standar").removeClass("d-none");
                        $(".sub-standar").removeClass("d-none");
                    }
                    // poin
                    if (res.data.nama_poin != null) {
                        $('#lembaga_akreditasi_id').val(res.data.daftar_sub_standar.daftar_standar_mutu
                            .lembaga_akreditasi_id);
                        $('#tahun_periode_id').val(res.data.daftar_sub_standar.daftar_standar_mutu
                            .tahun_periode_id);
                        $('#myForm').find('.summernote').summernote('code', res.data.nama_poin);
                        $('#kategori').val('Poin');
                        $('#jenjang').val(res.data.jenjang);
                        $('#isian_rumus').val(res.data.isian_rumus);
                        $('#jenis_perhitungan').val(res.data.jenis_perhitungan);
                        $(".standar").removeClass("d-none");
                        $(".sub-standar").removeClass("d-none");
                        res.data.prodis.forEach(function(prodi) {
                            $('#prodi-' + prodi.id).prop('checked', true);
                        });
                        console.log(res.data.prodis);

                    }
                    $('#deskripsi').val(res.data.deskripsi);
                    $('#myForm').find('.summernote').summernote('code', res.data.nama_standar_mutu);

                },
                error: function(data) {
                    console.log(data.errors);
                    $('#myForm').trigger("reset");
                    alertNotify('error', data.responseJSON.message);
                }
            });
        }

        // trigger delete
        function deleteFunc(id, type) {
            if (confirm("Delete Record?") == true) {
                var id = id;
                let urlEdit;
                if (type == 'daftar-standar-mutu') {
                    urlEdit = `{{ route('daftar-standar-mutu.delete') }}`
                } else if (type == 'daftar-standar') {
                    urlEdit = `{{ route('daftar-standar.delete') }}`
                } else if (type == 'daftar-sub-standar') {
                    urlEdit = `{{ route('daftar-sub-standar.delete') }}`
                } else if (type == 'poin') {
                    urlEdit = `{{ route('poin.delete') }}`
                }
                // ajax
                $.ajax({
                    type: "DELETE",
                    url: urlEdit,
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
                        console.log(data.errors);

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
                    $(".standar").addClass("d-none").fadeOut();
                    $(".sub-standar").addClass("d-none").fadeOut();
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
            } else if ($(this).val() == 'Poin') {
                $(".sub-standar").removeClass("d-none").fadeIn();
                $('#myForm').attr('action', `{{ route('poin.store') }}`);
            } else if ($(this).val() == 'Standar') {
                $('#myForm').attr('action', `{{ route('daftar-standar.store') }}`);
            } else {
                $(".sub-standar").addClass("d-none").fadeOut();
            }
        });
        // Fungsi untuk tampilkan modal dengan data indikator jika ada id  
        function addIndikator(poin) {
            // Reset form and set poin value
            $('#myFormindikator').trigger("reset");
            $('#poin_id').val(poin);

            // Show modal immediately while loading data
            $('#modal-form-indikator').modal('show');

            // AJAX call with better error handling and cleaner code
            $.ajax({
                type: "GET",
                url: "{{ route('indikator.edit') }}",
                data: {
                    id: poin
                }, // Using the passed poin parameter as id
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        const data = response.data;
                        console.log(data);
                        $('input[name="id"]').val(data.id);
                        // Simplified field population
                        const fields = [
                            'id', 'sangat_kurang', 'kurang',
                            'cukup_baik', 'baik', 'sangat_baik'
                        ];

                        fields.forEach(field => {
                            $(`#${field}`).val(data[field] ?? '');
                        });
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    const message = response?.message || "Terjadi kesalahan";

                    if (response?.status?.code === 404) {
                        alertNotify('error', "Data belum diisi");
                    } else {
                        alertNotify('error', message);
                    }
                }
            });
        }

        // Pastikan ini hanya didaftarkan sekali, misalnya di document ready  
        $('#myFormindikator').submit(function(e) {
            e.preventDefault();
            $("#btn-indikator").html(`  
            <div class="spinner-border spinner-border-sm" role="status">  
                <span class="visually-hidden">Loading...</span>  
            </div> Loading...  
            `);
            $("#btn-indikator").attr("disabled", true);

            let formData = new FormData(this); // ambil semua data form otomatis  

            $.ajax({
                type: 'POST',
                url: "{{ route('indikator.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#modal-form-indikator").modal('hide');
                    var oTable = $('#data-table').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-indikator").html("Simpan");
                    $("#btn-indikator").attr("disabled", false);
                    alertNotify('success', data.message);
                },
                error: function(data) {
                    $("#btn-indikator").html("Simpan");
                    $("#btn-indikator").attr("disabled", false);
                    loopErrors(data.responseJSON.errors);
                    alertNotify('error', data.responseJSON.message);
                }
            });
        });
    </script>
@endsection
