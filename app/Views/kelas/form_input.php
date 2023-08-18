<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="nama_kelas" class="col-form-label">Nama Kelas</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_kelas" name="nama_kelas[]" value="<?= (isset($get->nama_kelas)) ? $get->nama_kelas : ''; ?>" placeholder="Nama Kelas" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />