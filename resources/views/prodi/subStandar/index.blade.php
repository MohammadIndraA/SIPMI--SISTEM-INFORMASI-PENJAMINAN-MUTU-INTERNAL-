@extends('layouts.main')
@section('title', 'Evalusi Diri')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Page</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Table</a></li>
                        {{-- <li class="breadcrumb-item active"><a
                                href="{{ route('prodi.substandar.index', ['fakultas' => request()->segment(3) , 'poin']) }}"
                                style="color: darkgrey ; text-decoration: none">Evalusi Diri</a>
                        </li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card border-1">
                        <div class="row p-4">
                            <table class="table table-striped table-centered mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            Periode
                                        </td>
                                        <td>: 2021</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lembaga Akreditasi
                                        </td>
                                        <td>: SPMI</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Standar Nasional
                                        </td>
                                        <td width="75%">: STANDAR PENDIDIKAN NASIONAL</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Jumlah standar Mutu
                                        </td>
                                        <td width="75%">: STANDAR PENDIDIKAN NASIONAL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="card-header py-2">
                                <strong>
                                    <h5>STANDAR MUTU</h5>
                                </strong>
                            </div>
                            <div class="card-body">
                                1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid ??
                                <div class="pt-1">
                                    <div class="form-check py-1">
                                        <input type="radio" id="customRadio1" name="customRadio" class="form-check-input">
                                        <label class="form-check-label" for="customRadio1">Toggle this custom radio</label>
                                    </div>
                                    <div class="form-check py-1">
                                        <input type="radio" id="customRadio1" name="customRadio" class="form-check-input">
                                        <label class="form-check-label" for="customRadio1">Toggle this custom radio</label>
                                    </div>
                                    <div class="form-check py-1">
                                        <input type="radio" id="customRadio1" name="customRadio" class="form-check-input">
                                        <label class="form-check-label" for="customRadio1">Toggle this custom radio</label>
                                    </div>
                                </div>
                                <hr>
                                <span>Upload File</span>
                                <hr>
                                <div class="col d-flex justify-content-between">
                                    <button type="button" onclick="ShowFilePendukung()" class="btn btn-info btn-sm">
                                        <i class="mdi mdi-file me-1"></i> <span>Pilih File</span>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-plus-circle me-1"></i> <span>Tambah</span>
                                    </button>
                                </div>

                                <hr>

                                <div class="col d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-window-close me-1"></i> <span>Close</span>
                                    </button>
                                    <a href="#" class="btn btn-dark btn-sm">
                                        <span>Selanjutnya</span> <i class="mdi mdi-arrow-right ms-1"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    {{-- modal --}}

    <x-modal>
        <div class="modal-body">
            <x-slot name="size">
                modal-lg
            </x-slot>
            <div class="col-sm-4 pt-1 pb-3">
                <a href="#" class="btn btn-primary btn-sm mb-2"
                    onClick="addFilePendukung('{{ route('prodi.bukti-pendukung.store') }}')"><i
                        class="mdi mdi-plus-circle me-2"></i>
                    Upload File</a>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless nowrap" id="data-table">
                    <thead class="">
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th style="width: 50%;">Nama Dokumen</th>
                            <th>Kategori Dokumen</th>
                            <th>Unit Pengunggah</th>
                            <th style="width: 10px; text-align: center;">Aksi</th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
    </x-modal>

    {{-- modal add file pendukung --}}
    <x-modal-add-file-pendukung>
    </x-modal-add-file-pendukung>
    {{-- end modal --}}

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
                    url: "{{ route('prodi.bukti-pendukung.index') }}",
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
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'kategori_dokumen',
                        name: 'kategori_dokumen',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'unit_pengunggah',
                        name: 'unit_pengunggah',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
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

        // trigger modal show bukti pendukung
        function ShowFilePendukung() {
            $('#myForm').data('type', 'add');
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Daftar File Pendukung");
            $('#modal-form').modal('show');
            $('#id').val('');
        }

        // trigger add modal show bukti pendukung
        function addFilePendukung(url) {
            $('#myFormFilePendukung').attr('action', url);
            $('#myFormFilePendukung').trigger("reset");
            $('#myFormFilePendukung').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myFormFilePendukung').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title-file').text("Daftar File Pendukung");
            $('#modal-form-file').modal('show');
            $('#modal-form').css('opacity', '0.5');
        }
        $('#modal-form-file').on('hidden.bs.modal', function() {
            $('#modal-form').css('opacity', '1'); // Mengembalikan opacity setelah modal kedua ditutup
        });


        // submit
        // submit form with ajax
        // submit form with ajax
        $('#myFormFilePendukung').submit(function(e) {
            $("#btn-file").html(`
            <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                     </div> Loading...
            `);
            $("#btn-file").attr("disabled", true);
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#modal-form-file").modal('hide');
                    var oTable = $('#data-table').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-file").html("Simpan");
                    $("#btn-file").attr("disabled", false);
                    alertNotify('success', data.message);
                },
                error: function(data) {
                    $("#btn-file").html("Simpan");
                    $("#btn-file").attr("disabled", false);
                    loopErrors(data.responseJSON.errors);
                    alertNotify('danger', data.responseJSON.message);
                }
            });
        });
    </script>
@endsection
