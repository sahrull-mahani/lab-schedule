<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="nama_lab" class="col-form-label">Nama Lab</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_lab" name="nama_lab[]" value="<?= (isset($get->nama_lab)) ? $get->nama_lab : ''; ?>" placeholder="Nama Laboratorium" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />