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
                                        <td>: {{ $tahun->tahun_periode }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lembaga Akreditasi
                                        </td>
                                        <td>: {{ $lembaga->lembaga_akreditasi }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Standar Nasional
                                        </td>
                                        <td width="75%">: {{ $sub_standars->daftar_standar_mutu->nama_standar_mutu }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Jumlah Pertanyaan
                                        </td>
                                        <td width="75%">: {{ $sub_standars->poins->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        @livewireStyles
                        {{-- <livewire:quiz-component /> --}}
                        <div class="card">
                            <div class="card-header py-2">
                                <strong>
                                    <h5>STANDAR MUTU</h5>
                                </strong>
                            </div>
                            <form id="jawabanForm" action="{{ route('auditor.simpan-jawaban-substandar-audit.store') }}"
                                method="POST">
                                @csrf
                                @if ($sub_standars->poins && $sub_standars->poins->count() > 0)
                                    <input type="hidden" name="sub_standar_id" value="{{ $sub_standars->id }}">
                                    @foreach ($sub_standars->poins as $index => $item)
                                        <input type="hidden" name="poin_id" value="{{ $item->id }}">
                                        <input type="hidden" name="prodi_fakultas" value="{{ request()->segment(3) }}">
                                        <div class="card-body">
                                            <h5>{{ $index + 1 }}. {{ $item->nama_poin }} <sop class="text-danger">
                                                    *
                                                </sop>
                                            </h5>
                                            <div class="row mb-1">
                                                <div class="pt-1 col-2">
                                                    <div class="form-check py-1">
                                                        <input type="radio" id="customRadioYa_{{ $item->id }}"
                                                            name="poin[{{ $item->id }}]" value="ya" disabled
                                                            class="form-check-input"
                                                            {{ old('poin.' . $item->id, $jawabans->get($item->id)->jawaban ?? '') == 'ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="customRadioYa_{{ $item->id }}">Ya</label>
                                                    </div>
                                                    <div class="form-check py-1">
                                                        <input type="radio" id="customRadioTidak_{{ $item->id }}"
                                                            name="poin[{{ $item->id }}]" value="tidak" disabled
                                                            class="form-check-input"
                                                            {{ old('poin.' . $item->id, $jawabans->get($item->id)->jawaban ?? '') == 'tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="customRadioTidak_{{ $item->id }}">Tidak</label>
                                                    </div>
                                                    <div class="form-check py-1">
                                                        <input type="radio" id="customRadioSebagian_{{ $item->id }}"
                                                            name="poin[{{ $item->id }}]" value="sebagian" disabled
                                                            class="form-check-input"
                                                            {{ old('poin.' . $item->id, $jawabans->get($item->id)->jawaban ?? '') == 'sebagian' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="customRadioSebagian_{{ $item->id }}">Sebagian</label>
                                                    </div>
                                                </div>

                                                {{-- <div class="col d-flex justify-content-between align-items-center"> --}}
                                                {{-- <span>Catatan</span> --}}

                                                {{-- </div> --}}

                                                <div class="col-10">
                                                    <span><strong>Hasil Evalusi Diri :</strong></span>
                                                    <textarea class="form-control mt-2" id="catatan_{{ $item->id }}" name="catatan[{{ $item->id }}]"
                                                        placeholder="-" disabled rows="2">{{ old('catatan.' . $item->id, $jawabans->get($item->id)->catatan ?? '') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="File Pendukung" class="col-2 col-form-label"><b>File
                                                        Pendukung</b>
                                                </label>
                                                <div class="col-10">
                                                    <button type="button" class="btn btn-sm w-100 text-start">
                                                        @if (!empty($file_pendukungs[$item->id]))
                                                            @foreach ($file_pendukungs[$item->id] as $file)
                                                                <a href="{{ asset('storage/' . $file->file_pendukung) }}"
                                                                    target="_blank"
                                                                    class="d-flex align-items-center text-decoration-none text-dark">
                                                                    <i class="mdi mdi-file-pdf me-1"
                                                                        style="font-size: 24px; color: red;"></i>
                                                                    <span>{{ $file->nama ?? 'File Pendukung' }}</span>
                                                                </a>
                                                            @endforeach
                                                        @else
                                                            <span>Tidak Ada Dokumen</span>
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>

                                            <hr>
                                            <span class="mb-1"><strong>Hasil Desk Evaluasi :</strong></span>
                                            <div class="row mb-1">
                                                <label for="Status" class="col-2 col-form-label"><b>Status</b>
                                                </label>
                                                <div class="col-10">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label ml-5 my-1" for="Terverifikasi">
                                                            <input type="radio" disabled
                                                                name="status[{{ $item->id }}]"
                                                                class="form-check-input form-check-lg" id="Terverifikasi "
                                                                {{ old('status.' . $item->id, $jawaban_auditor->get($item->id)->status ?? '') == 'Terverifikasi' ? 'checked' : '' }}
                                                                value="Terverifikasi">
                                                            Terverifikasi </label>
                                                        <label class="form-check-label mx-4 my-1" for="memburuhkan_perbaia">
                                                            <input type="radio" disabled
                                                                name="status[{{ $item->id }}]"
                                                                class="form-check-input form-check-lg"
                                                                {{ old('status.' . $item->id, $jawaban_auditor->get($item->id)->status ?? '') == 'Membutuhkan Perbaikan' ? 'checked' : '' }}
                                                                id="memburuhkan_perbaia " value="Membutuhkan Perbaikan">
                                                            Membutuhkan Perbaikan </label>
                                                        <label class="form-check-label mx-2 my-1" for="tidak_terbukti">
                                                            <input type="radio" disabled
                                                                name="status[{{ $item->id }}]"
                                                                class="form-check-input form-check-lg"
                                                                {{ old('status.' . $item->id, $jawaban_auditor->get($item->id)->status ?? '') == 'Tidak Terbukti' ? 'checked' : '' }}
                                                                id="tidak_terbukti " value="Tidak Terbukti">
                                                            Tidak Terbukti </label>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="Temuan" class="col-2 col-form-label"><b>Daftar Temuan</b>
                                                </label>
                                                <div class="col-10">
                                                    <textarea class="form-control" disabled id="Temuan" name="temuan[{{ $item->id }}]"
                                                        value="{{ old('Temuan') }}" placeholder="-" rows="3">{{ old('temuan.' . $item->id, $jawaban_auditor->get($item->id)->temuan ?? '') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="Rekomendasi" class="col-2 col-form-label"><b>Rekomendasi</b>
                                                </label>
                                                <div class="col-10">
                                                    <textarea class="form-control" disabled id="Rekomendasi" name="rekomendasi[{{ $item->id }}]" placeholder="-"
                                                        rows="3"> {{ old('rekomendasi.' . $item->id, $jawaban_auditor->get($item->id)->rekomendasi ?? '') }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">Belum ada poin untuk sub standar ini.</div>
                                @endif
                                <div class="card p-3">
                                    <span><span class="mb-1"><strong>Visitasi :</strong></span></span>
                                    <div class="row mb-1">
                                        <label for="temuan" class="col-2 col-form-label"><b>Temuan</b>
                                        </label>
                                        <div class="col-10">
                                            <textarea class="form-control" id="temuan" name="temuan" placeholder="-" rows="3"> </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        onclick="window.history.back()">
                                        <i class="mdi mdi-window-close me-1"></i> <span>Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm" id="btn-save">
                                        <i class="mdi mdi-content-save me-1"></i> <span>Simpan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- @livewireScripts --}}
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
                    onClick="addFilePendukung('{{ route('prodi.bukti-pendukung.store') }}', {{ $sub_standars->id }})"><i
                        class="mdi mdi-plus-circle me-2"></i>
                    Upload File</a>
            </div>
            <input type="hidden" name="poin_standar" id="poin_standar">
            <div class="table-responsive">
                <table class="table table-borderless nowrap" id="data-table">
                    <thead class="">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 50%;">Nama Dokumen</th>
                            <th style="width: 15%;">Kategori Dokumen</th>
                            <th style="width: 15%;">Unit Pengunggah</th>
                            <th style="width: 5%;">Aksi</th>
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

            var baseUrl = "{{ route('prodi.bukti-pendukung.index') }}";
            var poin_pendukung = $('#poin_standar').val() ?? null;
            var sub_standar_id = "{{ $sub_standars->id }}";
            var url = baseUrl + '?sub_standar=' + sub_standar_id + '&poin_id=' + poin_pendukung;

            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
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
        function ShowFilePendukung($poin_id) {
            $('#myForm').data('type', 'add');
            $('#myForm').trigger("reset");
            $('#myForm').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myForm').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title').text("Daftar File Pendukung");
            $('#modal-form').modal('show');
            $('#id').val('');
            $('#poin_standar').val($poin_id);

        }

        // trigger add modal show bukti pendukung
        function addFilePendukung(url, $sub_standar) {
            $('#myFormFilePendukung').attr('action', url);
            $('#myFormFilePendukung').trigger("reset");
            $('#myFormFilePendukung').find('.is-invalid').removeClass('is-invalid'); // Remove validation errors
            $('#myFormFilePendukung').find('.invalid-feedback').text(''); // Clear validation error messages
            $('#modal-title-file').text("Daftar File Pendukung");
            $('#modal-form-file').modal('show');
            $('#modal-form').css('opacity', '0.5');
            $('#poin_id_pendukung').val($('#poin_standar').val());
            $('#daftar_sub_standar_id_pendukung').val($sub_standar);
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

        // save jawaban
        $('#jawabanForm').on('submit', function(e) {
            $("#btn-save").html(`
            <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                     </div> Loading...
            `);
            $("#btn-save").attr("disabled", true);
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
                    alertNotify('success', data.message);
                    $("#btn-save").html("Simpan");
                    $("#btn-save").attr("disabled", false);
                    location.reload();
                },
                error: function(data) {
                    $("#btn-save").html("Simpan");
                    $("#btn-save").attr("disabled", false);
                    loopErrors(data.responseJSON.errors);
                    alertNotify('danger', data.responseJSON.message);
                }
            });
        });
    </script>
@endsection
