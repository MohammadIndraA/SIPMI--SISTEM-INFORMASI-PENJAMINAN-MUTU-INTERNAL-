    <div class="modal fade" id="modal-form-indikator" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Indikator Input</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <form action="#" method="post" class="form-horizontal" enctype="multipart/form-data"
                    id="myFormindikator">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="poin_id" id="poin_id">
                        <div class="row mb-1">
                            <label for="sangat_kurang" class="col-3 col-form-label"><b>0 (Sangat Kurang)</b>
                            </label>
                            <div class="col-9">
                                <textarea class="form-control" id="sangat_kurang" name="sangat_kurang" value="{{ old('sangat_kurang') }}"
                                    placeholder="-" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="kurang" class="col-3 col-form-label"><b>1 (Kurang)</b>
                            </label>
                            <div class="col-9">
                                <textarea class="form-control" id="kurang" name="kurang" value="{{ old('kurang') }}" placeholder="-" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="cukup_baik" class="col-3 col-form-label"><b>2 (Cukup Baik)</b>
                            </label>
                            <div class="col-9">
                                <textarea class="form-control" id="cukup_baik" name="cukup_baik" value="{{ old('cukup_baik') }}" placeholder="-"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="baik" class="col-3 col-form-label"><b>3 (Baik)</b>
                            </label>
                            <div class="col-9">
                                <textarea class="form-control" id="baik" name="baik" value="{{ old('baik') }}" placeholder="-" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="sangat_baik" class="col-3 col-form-label"><b>4 (Sangat Baik)</b>
                            </label>
                            <div class="col-9">
                                <textarea class="form-control" id="sangat_baik" name="sangat_baik" value="{{ old('sangat_baik') }}" placeholder="-"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnClose"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btn-indikator" class="btn btn-primary">Simpan</button>
                    </div> <!-- end modal footer -->
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->
