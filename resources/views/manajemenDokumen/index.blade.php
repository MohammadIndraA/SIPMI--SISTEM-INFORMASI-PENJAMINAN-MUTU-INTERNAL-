@extends('layouts.main')
@section('title', 'Kategori Dokumen')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        <li class="breadcrumb-item active">Kategori Dokumen</li>
                    </ol>
                </div>
                <h4 class="page-title">Kategori Dokumen</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('view-manajemen-dokumen')
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('manajemen-dokumen.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>
                                    Tambah Kategori Dokumen</a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless dt-responsive nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Dokumen</th>
                                    <th>Kategori Dokumen</th>
                                    <th>File</th>
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
                <label for="nama_dokumen" class="col-3 col-form-label">Nama Dokumen <sop class="text-danger">*</sop>
                </label>
                <div class="col-8">
                    <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen"
                        value="{{ old('nama_dokumen') }}" placeholder="SOP CUTI">
                </div>
            </div>
            <div class="row mb-1">
                <label for="kategori_dokumen_id" class="col-3 col-form-label">Nama Dokumen <sop class="text-danger">*</sop>
                </label>
                <div class="col-8">
                    <select class="form-select" id="kategori_dokumen_id" name="kategori_dokumen_id">
                        @foreach ($kategoriDokumens as $item)
                            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <label for="file_dokumen" class="col-3 col-form-label">File <sop class="text-danger">*</sop>
                </label>
                <div class="col-8">
                    <input type="file" class="form-control" name="file_dokumen" id="file_dokumen"
                        value="{{ old('file_dokumen') }}" placeholder="SOP CUTI">
                </div>
            </div>
            <div class="row mb-1">
                <label for="" class="col-3 col-form-label">
                </label>
                <div class="col-8">
                    <span class="text-danger">* File berupa PDF, maximal 5MB</span>
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
                ajax: "{{ route('manajemen-dokumen.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'nama_dokumen',
                        name: 'nama_dokumen'
                    },
                    {
                        data: 'kategori_dokumen_id',
                        name: 'kategori_dokumen_id',
                        render: function(data, type, row) {
                            return row.kategori_dokumen.kategori;
                        }
                    },
                    {
                        data: 'file_dokumen',
                        name: 'file_dokumen'
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
            $('#modal-title').text("Tambah Data Manajemen Dokumen");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Tambah Data Manajemen Dokumen");
            $('#modal-form').modal('show');
            // url action to update
            let url = `{{ route('manajemen-dokumen.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('manajemen-dokumen.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Manajemen Dokumen");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#nama_dokumen').val(res.data.nama_dokumen);
                    $('#kategori_dokumen_id').val(res.data.kategori_dokumen_id);
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
                    url: "{{ route('manajemen-dokumen.delete') }}",
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
