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
                        <li class="breadcrumb-item active">Tahun Periode</li>
                    </ol>
                </div>
                <h4 class="page-title">Tahun Periode</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('view-tahun-periode')
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('tahun-periode.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>
                                    Add Tahun Periode</a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless dt-responsive nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Tahun Periode</th>
                                    <th>Status</th>
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
            <div class="row mb-1">
                <label for="tahun_periode" class="col-3 col-form-label">Tahun <sop class="text-danger">*</sop> </label>
                <div class="col-9">
                    <input type="text" class="form-control" name="tahun_periode" id="tahun_periode"
                        value="{{ old('tahun_periode') }}" placeholder="2024">
                </div>
            </div>
            <div class="row">
                <label for="status" class="col-3 col-form-label">Status <sop class="text-danger">*</sop> </label>
                <div class="col-9">
                    <div class="form-check form-check-inline">
                        <input type="radio" id="aktif" name="status" value="Aktif" checked class="form-check-input">
                        <label class="form-check-label" for="aktif">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="tidak_aktif" name="status" value="Tidak Aktif" class="form-check-input">
                        <label class="form-check-label" for="tidak_aktif">Tidak Aktif</label>
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
                ajax: "{{ route('tahun-periode.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'tahun_periode',
                        name: 'tahun_periode'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            return (data === 'Aktif' ?
                                '<span class="badge badge-outline-success rounded-pill">' +
                                data +
                                '</span>' :
                                '<span class="badge badge-outline-danger rounded-pill">' +
                                data +
                                '</span>'
                            );
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
            $('#modal-title').text("Tambah Data Tahun Periode");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger edit modal
        function editFunc(id) {
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Edit Data Tahun Periode");
            $('#modal-form').modal('show');
            // url action to update
            let url = `{{ route('tahun-periode.update', 'id') }}`
            $('#myForm').attr('action', url.replace('id', id));
            $('#myForm').data('type', 'edit');

            $.ajax({
                type: "GET",
                url: "{{ route('tahun-periode.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-title').html("Edit Data Tahun Periode");
                    $('#modal-form').modal('show');
                    $('#id').val(res.data.id);
                    $('#tahun_periode').val(res.data.tahun_periode);
                    // Menyetel nilai status berdasarkan data yang diterima
                    if (res.data.status === 'Aktif') {
                        $('#aktif').prop('checked', true);
                    } else if (res.data.status === 'Tidak Aktif') {
                        $('#tidak_aktif').prop('checked', true);
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
                    url: "{{ route('tahun-periode.delete') }}",
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
