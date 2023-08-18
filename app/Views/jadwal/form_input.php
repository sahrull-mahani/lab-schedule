<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="dosen_id" class="col-form-label">Dosen</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Dosen==');
        foreach ($dosen as $row) {
            $dosens[$row->id] = $row->nama_penjabat;
        }
        echo form_dropdown('dosen_id[]', $defaults + ($dosens ?? []), (isset($get->dosen_id)) ? $get->dosen_id : '', 'class="form-control border" id="dosen_id" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="mk_id" class="col-form-label">Mata Kuliah</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Mata Kuliah==');
        foreach ($matakuliah as $row) {
            $mks[$row->id] = $row->nama_mk;
        }
        echo form_dropdown('mk_id[]', $defaults + ($mks ?? []), (isset($get->mk_id)) ? $get->mk_id : '', 'class="form-control border" id="mk_id" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="kelas_id" class="col-form-label">Kelas</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Kelas==');
        foreach ($kelas as $row) {
            $kelass[$row->id] = $row->nama_kelas;
        }
        echo form_dropdown('kelas_id[]', $defaults + ($kelass ?? []), (isset($get->kelas_id)) ? $get->kelas_id : '', 'class="form-control border" id="kelas_id" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
    <div class="item">
        <input type="time" class="form-control border" id="jam_mulai" name="jam_mulai[]" value="<?= (isset($get->jam_mulai)) ? $get->jam_mulai : ''; ?>" placeholder="Jam Mulai" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="jam_akhir" class="col-form-label">Jam Akhir</label>
    <div class="item">
        <input type="time" class="form-control border" id="jam_akhir" name="jam_akhir[]" value="<?= (isset($get->jam_akhir)) ? $get->jam_akhir : ''; ?>" placeholder="Jam Akhir" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="tanggal" class="col-form-label">Tanggal</label>
    <div class="item">
        <input type="date" class="form-control border datepicker" id="tanggal" name="tanggal[]" value="<?= (isset($get->tanggal)) ? date('Y-m-d', strtotime($get->tanggal)) : ''; ?>" placeholder="Tanggal" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />