<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="kelas_id" class="col-form-label">Kelas</label>
    <div class="item">
        <?php $defaults = array('' => '==Pilih Kelas==');
        foreach ($kelas as $row) {
            $options[$row->id] = $row->nama_kelas;
        }
        echo form_dropdown('kelas_id[]', $defaults + $options, (isset($get->kelas_id)) ? $get->kelas_id : '', 'class="form-control border" id="jk" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="nomor_induk" class="col-form-label">NIM</label>
    <div class="item">
        <input type="text" class="form-control border" id="nomor_induk" name="nomor_induk[]" value="<?= (isset($get->nomor_induk)) ? $get->nomor_induk : ''; ?>" placeholder="Nomor Induk Mahasiswa" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="nama_penjabat" class="col-form-label">Nama Mahasiswa</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_penjabat" name="nama_penjabat[]" value="<?= (isset($get->nama_penjabat)) ? $get->nama_penjabat : ''; ?>" placeholder="Nama Mahasiswa" required />
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
        <input type="date" class="form-control border" id="tgl_lahir" name="tgl_lahir[]" value="<?= (isset($get->tgl_lahir)) ? date('Y-m-d',strtotime($get->tgl_lahir)) : ''; ?>" placeholder="Tanggal Lahir" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="alamat" class="col-form-label">Alamat</label>
    <div class="item">
        <input type="text" class="form-control border" id="alamat" name="alamat[]" value="<?= (isset($get->alamat)) ? $get->alamat : ''; ?>" placeholder="Alamat" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />