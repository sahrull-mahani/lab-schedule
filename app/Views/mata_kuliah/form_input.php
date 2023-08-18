<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="nama_mk" class="col-form-label">Mata Kuliah</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_mk" name="nama_mk[]" value="<?= (isset($get->nama_mk)) ? $get->nama_mk : ''; ?>" placeholder="Nama Mk" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />