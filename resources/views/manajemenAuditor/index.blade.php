@extends('layouts.main')
@section('title', 'Manajemen Auditor')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Manajemen Auditor</li>
                    </ol>
                </div>
                <h4 class="page-title">Manajemen Auditor</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('view-manajemen-auditor')
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('manajemen-auditor.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>
                                    Tambah Auditor</a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>NIK</th>
                                    <th>Nama Assesor</th>
                                    <th>Lembaga Akreditasi</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Instansi</th>
                                    <th>jabatan</th>
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
                <label for="nik" class="col-3 col-form-label">NIK <sop class="text-danger">*</sop> </label>
                <div class="col-9">
                    <input type="text" class="form-control" name="nik" id="nik" value="{{ old('nik') }}"
                        placeholder="12345678910">
                </div>
            </div>
            <div class="row mb-1">
                <label for="nama_assesor" class="col-3 col-form-label">Nama Assesor <sop class="text-danger">*</sop>
                </label>
                <div class="col-2">
                    <input type="text" class="form-control" name="gelar_awal" id="gelar_awal"
                        value="{{ old('gelar_awal') }}" placeholder="Prof. Dr.">
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="nama_assesor" id="nama_assesor"
                        value="{{ old('nama_assesor') }}" placeholder="Mohammad Indra">
                </div>
                <div class="col-2">
                    <input type="text" class="form-control" name="gelar_akhir" id="gelar_akhir"
                        value="{{ old('gelar_akhir') }}" placeholder="M.Si">
                </div>
            </div>
            <div class="row mb-1 mt-2">
                <label for="lembaga_akreditasi_id" class="col-3 col-form-label">Lembaga Akreditasi <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <select class="form-select mb-1" id="lembaga_akreditasi_id" name="lembaga_akreditasi_id">
                        @foreach ($lembagaAkreditasis as $item)
                            <option value="{{ $item->id }}">{{ $item->lembaga_akreditasi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <label for="jenis_kelamin" class="col-3 col-form-label">Jenis Kelamain <sop class="text-danger">*</sop>
                </label>
                <div class="col-9">
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Laki-Laki" name="jenis_kelamin" value="Laki-Laki" checked
                            class="form-check-input">
                        <label class="form-check-label" for="Laki-Laki">Laki-Laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Perempuan" name="jenis_kelamin" value="Perempuan"
                            class="form-check-input">
                        <label class="form-check-label" for="Perempuan">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <label for="instansi" class="col-3 col-form-label">Instansi <sop class="text-danger">*</sop> </label>
                <div class="col-9">
                    <input type="text" class="form-control" name="instansi" id="instansi"
                        value="{{ old('instansi') }}" placeholder="LPMPP">
                </div>
            </div>
            <div class="row mb-1">
                <label for="jabatan" class="col-3 col-form-label">Jabatan <sop class="text-danger">*</sop> </label>
                <div class="col-9">
                    <input type="text" class="form-control" name="jabatan" id="jabatan"
                        value="{{ old('jabatan') }}" placeholder="Kepala Pusat Penjamianan Mutu Internal">
                </div>
            </div>
            <div class="row mb-1">
                <label for="fakultas_prodi" class="col-3 col-form-label">Program Studi <sop class="text-danger">
                        *
                    </sop>
                </label>
                <div class="col-9">
                    <div class="form-check form-check-inline">
                        @foreach ($fakultasProdi as $item)
                            <label class="form-check-label pe-4 my-1" for="fakultas_prodi-{{ $item->id }}"> <input
                                    type="checkbox" name="fakultas_prodi_id[]" class="form-check-input form-check-lg"
                                    id="fakultas_prodi-{{ $item->id }}" value="{{ $item->id }}">
                                {{ $item->fakultas_prodi }}</label>
                        @endforeach
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
                ajax: "{{ route('manajemen-auditor.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama_assesor',
                        name: 'nama_assesor',
                        render: function(data, type, row) {
                            return row.gelar_awal + ' ' + row.nama_assesor + ' ' + row.gelar_akhir;
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
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan',
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
            $('#modal-title').text("Tambah Data Manajemen Auditor");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Edit Data Manajemen Auditor");
            $('#modal-form').modal('show');
            // url action to update
            let url = `{{ route('manajemen-auditor.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('manajemen-auditor.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res);

                    $('#modal-title').html("Edit Data Manajemen Auditor");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#nik').val(res.data.nik);
                    $('#nama_assesor').val(res.data.nama_assesor);
                    $('#lembaga_akreditasi_id').val(res.data.lembaga_akreditasi_id);
                    res.data.fakultas_prodis.forEach(function(fakultas_prodi) {
                        $('#fakultas_prodi-' + fakultas_prodi.id).prop('checked', true);
                    });
                    $('#gelar_awal').val(res.data.gelar_awal);
                    $('#gelar_akhir').val(res.data.gelar_akhir);
                    $('#instansi').val(res.data.instansi);
                    $('#jabatan').val(res.data.jabatan);
                    // Menyetel nilai status berdasarkan data yang diterima
                    if (res.data.jenis_kelamin === 'Laki-laki') {
                        $('#Laki-laki').prop('checked', true);
                    } else if (res.data.jenis_kelamin === 'Perempuan') {
                        $('#Perempuan').prop('checked', true);
                    }
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
                    url: "{{ route('manajemen-auditor.delete') }}",
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
