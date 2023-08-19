<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="kode_mk" class="col-form-label">Kode Mk</label>
    <div class="item">
        <input type="text" class="form-control border" id="kode_mk" name="kode_mk[]" value="<?= @$get->kode_mk ?>" placeholder="Kode mata Kuliah" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="nama_mk" class="col-form-label">Nama Mk</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_mk" name="nama_mk[]" value="<?= @$get->nama_mk ?>" placeholder="Nama Mata Kuliah" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= @$get->id ?>" />