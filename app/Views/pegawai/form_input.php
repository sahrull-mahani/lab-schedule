<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="input-group input-group-outline my-3">
    <?php $defaults = array('' => '==Pilih Jabatan==');
    foreach ($jabatan as $key => $row) {
        $options[$row->id] = $row->nama;
    }
    echo form_dropdown('jab_id[]', $defaults + $options, (isset($get->jab_id)) ? $get->jab_id : '', 'class="form-control" id="jk" ');
    ?>
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="nama" name="nama[]" value="<?= (isset($get->nama)) ? $get->nama : ''; ?>" placeholder="Nama" required />
</div>
<div class="input-group input-group-outline my-3">
    <?php $defaults = array('' => '==Pilih Jk==');
    $options = array(
        'Laki-laki' => 'Laki-laki',
        'Perempuan' => 'Perempuan',
    );
    echo form_dropdown('jk[]', $defaults + $options, (isset($get->jk)) ? $get->jk : '', 'class="form-control" id="jk" ');
    ?>
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir[]" value="<?= (isset($get->tempat_lahir)) ? $get->tempat_lahir : ''; ?>" placeholder="Tempat Lahir" />
</div>
<div class="input-group input-group-outline my-3">
    <input type="date" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir[]" value="<?= (isset($get->tgl_lahir)) ? get_format_date_sql($get->tgl_lahir) : ''; ?>" placeholder="Tgl Lahir" />
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="gelar_depan" name="gelar_depan[]" value="<?= (isset($get->gelar_depan)) ? $get->gelar_depan : ''; ?>" placeholder="Gelar Depan" />
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang[]" value="<?= (isset($get->gelar_belakang)) ? $get->gelar_belakang : ''; ?>" placeholder="Gelar Belakang" />
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="alamat" name="alamat[]" value="<?= (isset($get->alamat)) ? $get->alamat : ''; ?>" placeholder="Alamat" />
</div>
<div class="input-group input-group-outline my-3">
    <?php $defaults = array('' => '==Pilih Pendidikan==');
    $options = array(
        'S3' => 'S3',
        'S2' => 'S2',
        'S1/D4' => 'S1/D4',
        'D3' => 'D3',
        'D2' => 'D2',
        'D1' => 'D1',
        'SMA/SMK/MA' => 'SMA/SMK/MA',
    );
    echo form_dropdown('pendidikan[]', $defaults + $options, (isset($get->pendidikan)) ? $get->pendidikan : '', 'class="form-control" id="pendidikan" ');
    ?>
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="lulusan" name="lulusan[]" value="<?= (isset($get->lulusan)) ? $get->lulusan : ''; ?>" placeholder="Lulusan" />
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />