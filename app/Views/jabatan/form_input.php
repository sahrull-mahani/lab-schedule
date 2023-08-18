<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="input-group input-group-outline my-3">
    <div class="input-group input-group-dynamic">
        <input type="text" class="form-control" id="level" name="level1[]" value="<?= (isset($get->level)) ? explode('.', $get->level)[0] : ''; ?>" placeholder="Contoh: 1" required />
        <input type="text" class="form-control" name="level2[]" value="<?= (isset($get->level)) ? explode('.', $get->level)[1] : ''; ?>" placeholder="Contoh: 0" required />
        <input type="text" class="form-control" name="level3[]" value="<?= (isset($get->level)) ? explode('.', $get->level)[2] : ''; ?>" placeholder="Contoh: 0" required />
    </div>
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="nama" name="nama[]" value="<?= (isset($get->nama)) ? $get->nama : ''; ?>" placeholder="Nama" required />
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />