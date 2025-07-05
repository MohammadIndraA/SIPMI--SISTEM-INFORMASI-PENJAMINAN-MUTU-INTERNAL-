    <div class="modal fade" id="modal-form-file" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modal-title-file" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Tambah File Pendukung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <form action="#" method="post" class="form-horizontal" enctype="multipart/form-data"
                    id="myFormFilePendukung">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="poin_id_pendukung" id="poin_id_pendukung">
                        <input type="hidden" name="daftar_sub_standar_id_pendukung"
                            id="daftar_sub_standar_id_pendukung">
                        <div class="row mb-1">
                            <label for="nama" class="col-3 col-form-label"><b>Nama File Pendukung</b>
                                <sop class="text-danger">*
                                </sop>
                            </label>
                            <div class="col-9">
                                <input type="text" class="form-control" name="nama" id="nama"
                                    value="{{ old('nama') }}" placeholder="File Pendukung"></input>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="kategori_dokumen_id" class="col-3 col-form-label">Kategori <sop
                                    class="text-danger">*
                                </sop>
                            </label>
                            <div class="col-9">
                                <select class="form-select form-select-sm mb-1" id="kategori_dokumen_id"
                                    name="kategori_dokumen_id">
                                    @foreach ($kategori_dokumens as $item)
                                        <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="file_pendukung" class="col-3 col-form-label"><b>File Pendukung</b>
                                <sop class="text-danger">*
                                </sop>
                            </label>
                            <div class="col-9">
                                <input type="file" class="form-control" name="file_pendukung"
                                    id="file_pendukung"></input>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnClose"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-file" class="btn btn-primary">Simpan</button>
                    </div> <!-- end modal footer -->
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->
