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
            <label for="nama_standar_mutu" class="col-3 col-form-label">Nama Standar Mutu <sop class="text-danger">*
                </sop>
            </label>
            <div class="col-9">
                <div id="snow-editor" name="nama_standar_mutu" data-nama_standar_mutu="nama_standar_mutu"
                    value="{{ old('nama_standar_mutu') }}" style="height: 150px;"></div>
            </div>
        </div>
        <div class="row mb-1 standar">
            <label for="kategori" class="col-3 col-form-label">Standar Akreditasi <sop class="text-danger">
                    *
                </sop>
            </label>
            <div class="col-9">
                <select class="form-select form-select-sm mb-1" id="kategori" name="kategori">
                    <option value="Standar">Standar</option>
                    <option value="Sub Standar">Sub Standar</option>
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
    </div>
</x-modal>
