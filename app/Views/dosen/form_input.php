<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="nomor_induk" class="col-form-label">NIDN</label>
    <div class="item">
        <input type="text" class="form-control border" id="nomor_induk" name="nomor_induk[]" value="<?= (isset($get->nomor_induk)) ? $get->nomor_induk : ''; ?>" placeholder="Nomor Induk Dosen Nasional" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="nama_penjabat" class="col-form-label">Nama Dosen</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_penjabat" name="nama_penjabat[]" value="<?= (isset($get->nama_penjabat)) ? $get->nama_penjabat : ''; ?>" placeholder="Nama Dosen" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="jk" class="col-form-label">Jenis Kelamin</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Jenis Kelamin==');
        $options = array(
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        );
        echo form_dropdown('jk[]', $defaults + $options, (isset($get->jk)) ? $get->jk : '', 'class="form-control border" id="jk" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="tempat_lahir" class="col-form-label">Tempat Lahir</label>
    <div class="item">
        <input type="text" class="form-control border" id="tempat_lahir" name="tempat_lahir[]" value="<?= (isset($get->tempat_lahir)) ? $get->tempat_lahir : ''; ?>" placeholder="Tempat Lahir" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="tgl_lahir" class="col-form-label">Tanggal Lahir</label>
    <div class="item">
        <input type="date" class="form-control border datepicker" id="tgl_lahir" name="tgl_lahir[]" value="<?= (isset($get->tgl_lahir)) ? date('Y-m-d',strtotime($get->tgl_lahir)) : ''; ?>" placeholder="Tanggal Lahir" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="gelar_depan" class="col-form-label">Gelar Depan</label>
    <div class="item">
        <input type="text" class="form-control border" id="gelar_depan" name="gelar_depan[]" value="<?= (isset($get->gelar_depan)) ? $get->gelar_depan : ''; ?>" placeholder="Gelar Depan" />
    </div>
</div>
<div class="form-group mode2">
    <label for="gelar_belakang" class="col-form-label">Gelar Belakang</label>
    <div class="item">
        <input type="text" class="form-control border" id="gelar_belakang" name="gelar_belakang[]" value="<?= (isset($get->gelar_belakang)) ? $get->gelar_belakang : ''; ?>" placeholder="Gelar Belakang" />
    </div>
</div>
<div class="form-group mode2">
    <label for="alamat" class="col-form-label">Alamat</label>
    <div class="item">
        <input type="text" class="form-control border" id="alamat" name="alamat[]" value="<?= (isset($get->alamat)) ? $get->alamat : ''; ?>" placeholder="Alamat" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="pendidikan" class="col-form-label">Pendidikan</label>
    <div class="item">
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
        echo form_dropdown('pendidikan[]', $defaults + $options, (isset($get->pendidikan)) ? $get->pendidikan : '', 'class="form-control border" id="pendidikan" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="lulusan" class="col-form-label">Lulusan</label>
    <div class="item">
        <input type="text" class="form-control border" id="lulusan" name="lulusan[]" value="<?= (isset($get->lulusan)) ? $get->lulusan : ''; ?>" placeholder="Lulusan" />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />