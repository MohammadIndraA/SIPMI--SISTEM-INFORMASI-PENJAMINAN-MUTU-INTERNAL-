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
                    <div class="row mb-2">
                        @can('view-fakultas-prodi')
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary mb-2"
                                    onClick="addUser('{{ route('fakultas-prodi.store') }}')"><i
                                        class="mdi mdi-plus-circle me-2"></i>
                                    Add Daftar Temuan</a>
                            </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless dt-responsive nowrap" id="data-table">
                            <thead class="">
                                <tr>
                                    <th style="width: 5%; ">#</th>
                                    <th style="width: 50%; text-align: center">Standar Mutu</th>
                                    <th style="width: 30%; text-align: center">Daftar Temuan</th>
                                    {{-- <th style="width: 15%; text-align: center">Nilai Mutu</th> --}}
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
            <input type="hidden" name="poin_id" id="poin_id">
            <div class="row mb-1">
                <label for="root_cause" class="col-3 col-form-label"><b>Root Cause</b>
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="root_cause" name="root_cause" value="{{ old('root_cause') }}" placeholder="-"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="row mb-1">
                <label for="action_plan" class="col-3 col-form-label"><b>Action Plan</b>
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="action_plan" name="action_plan" value="{{ old('root_cause') }}" placeholder="-"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="row mb-1">
                <label for="Rekomendasi" class="col-3 col-form-label"><b>Rekomendasi</b>
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="Rekomendasi" name="Rekomendasi" value="{{ old('Rekomendasi') }}" placeholder="-"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="row mb-1">
                <label for="person_in_charge" class="col-3 col-form-label"><b>Person In Charge</b>
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="person_in_charge" name="person_in_charge" value="{{ old('person_in_charge') }}"
                        placeholder="-" rows="3"></textarea>
                </div>
            </div>
            <div class="row mb-1">
                <label for="target_waktu_penyelesaian" class="col-3 col-form-label"><b>Target Waktu Penyelesaian</b>
                </label>
                <div class="col-9">
                    <textarea class="form-control" id="target_waktu_penyelesaian" name="target_waktu_penyelesaian"
                        value="{{ old('target_waktu_penyelesaian') }}" placeholder="-" rows="3"></textarea>
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
                ajax: "{{ route('prodi.daftar-temuan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'daftar_sub_standar_id',
                        name: 'daftar_sub_standar_id'
                    },
                    // {
                    //     data: 'fakultas_prodi',
                    //     name: 'fakultas_prodi'
                    // },
                    {
                        data: 'jumlah_temuan',
                        name: 'jumlah_temuan'
                    },

                ]
            });
        });


        // trigger add modal
        function rencanaTindakLanjut(url, id) {
            $('#myForm').attr('action', url);
            $('#myForm').data('type', 'add');
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Rencana Tindak Lanjut");
            $('#modal-form').modal('show');
            $('#poin_id').val(id);
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
