<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group row mode2">
    <label for="dosen_id" class="col-sm-3 col-form-label">Dosen Id</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="dosen_id" name="dosen_id[]" value="<?= (isset($get->dosen_id)) ? $get->dosen_id : ''; ?>" placeholder="Dosen Id" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="mk_id" class="col-sm-3 col-form-label">Mk Id</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="mk_id" name="mk_id[]" value="<?= (isset($get->mk_id)) ? $get->mk_id : ''; ?>" placeholder="Mk Id" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="kelas_id" class="col-sm-3 col-form-label">Kelas Id</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="kelas_id" name="kelas_id[]" value="<?= (isset($get->kelas_id)) ? $get->kelas_id : ''; ?>" placeholder="Kelas Id" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="jam_mulai" class="col-sm-3 col-form-label">Jam Mulai</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="jam_mulai" name="jam_mulai[]" value="<?= (isset($get->jam_mulai)) ? $get->jam_mulai : ''; ?>" placeholder="Jam Mulai" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="jam_akhir" class="col-sm-3 col-form-label">Jam Akhir</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="jam_akhir" name="jam_akhir[]" value="<?= (isset($get->jam_akhir)) ? $get->jam_akhir : ''; ?>" placeholder="Jam Akhir" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control datepicker" id="tanggal" name="tanggal[]" value="<?= (isset($get->tanggal)) ? get_format_date($get->tanggal) : ''; ?>" placeholder="Tanggal" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />