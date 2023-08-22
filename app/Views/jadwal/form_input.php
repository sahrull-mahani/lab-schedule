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
<?php if ($aksi == 'edit') : ?>
    <div class="form-group mode2">
        <label for="dosen_id" class="col-form-label">Dosen Pengganti</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Dosen Pengganti==');
            foreach ($dosen as $row) {
                $dosens[$row->id] = $row->nama_penjabat;
            }
            echo form_dropdown('dosen_verify[]', $defaults + ($dosens ?? []), '', 'class="form-control border" id="dosen_verify"');
            ?>
        </div>
    </div>
<?php endif ?>
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
    <label for="lab_id" class="col-form-label">Laboratorium</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Laboratorium==');
        foreach ($laboratorium as $row) {
            $labs[$row->id] = $row->nama_lab;
        }
        echo form_dropdown('lab_id[]', $defaults + ($labs ?? []), (isset($get->lab_id)) ? $get->lab_id : '', 'class="form-control border" id="lab_id" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="waktu_mulai" class="col-form-label">Waktu Mulai</label>
    <div class="item">
        <input type="time" class="form-control border" id="waktu_mulai" name="waktu_mulai[]" value="<?= (isset($get->waktu_mulai)) ? $get->waktu_mulai : ''; ?>" placeholder="Waktu Mulai" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="waktu_selesai" class="col-form-label">Waktu Selesai</label>
    <div class="item">
        <input type="time" class="form-control border" id="waktu_selesai" name="waktu_selesai[]" value="<?= (isset($get->waktu_selesai)) ? $get->waktu_selesai : ''; ?>" placeholder="Waktu Selesai" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="hari" class="col-form-label">Hari</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Hari==');
        $options = array(
            'senin' => 'senin',
            'selasa' => 'selasa',
            'rabu' => 'rabu',
            'kamis' => 'kamis',
            'jumat' => "jum'at",
        );
        echo form_dropdown('hari[]', $defaults + $options, (isset($get->hari)) ? $get->hari : '', 'class="form-control border" id="hari" required');
        ?>
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />