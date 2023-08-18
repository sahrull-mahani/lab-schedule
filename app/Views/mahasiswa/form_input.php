<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group row mode2">
    <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
    <div class="col-sm-9 item">
        <?php $defaults = array(''=>'==Pilih Jabatan==');
            $options = array(
				'k-lab'=>'k-lab',
				'dosen'=>'dosen',
				'mahasiswa'=>'mahasiswa',
			);  
            echo form_dropdown('jabatan[]',$defaults + $options,(isset($get->jabatan)) ? $get->jabatan: '','class="form-control" id="jabatan" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="kelas_id" class="col-sm-3 col-form-label">Kelas Id</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="kelas_id" name="kelas_id[]" value="<?= (isset($get->kelas_id)) ? $get->kelas_id : ''; ?>" placeholder="Kelas Id"  />
    </div>
</div>
<div class="form-group row mode2">
    <label for="nomor_induk" class="col-sm-3 col-form-label">Nomor Induk</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk[]" value="<?= (isset($get->nomor_induk)) ? $get->nomor_induk : ''; ?>" placeholder="Nomor Induk" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="nama_penjabat" class="col-sm-3 col-form-label">Nama Penjabat</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="nama_penjabat" name="nama_penjabat[]" value="<?= (isset($get->nama_penjabat)) ? $get->nama_penjabat : ''; ?>" placeholder="Nama Penjabat" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="jk" class="col-sm-3 col-form-label">Jk</label>
    <div class="col-sm-9 item">
        <?php $defaults = array(''=>'==Pilih Jk==');
            $options = array(
				'Laki-laki'=>'Laki-laki',
				'Perempuan'=>'Perempuan',
			);  
            echo form_dropdown('jk[]',$defaults + $options,(isset($get->jk)) ? $get->jk: '','class="form-control" id="jk" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir[]" value="<?= (isset($get->tempat_lahir)) ? $get->tempat_lahir : ''; ?>" placeholder="Tempat Lahir" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="tgl_lahir" class="col-sm-3 col-form-label">Tgl Lahir</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir[]" value="<?= (isset($get->tgl_lahir)) ? get_format_date($get->tgl_lahir) : ''; ?>" placeholder="Tgl Lahir" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="gelar_depan" class="col-sm-3 col-form-label">Gelar Depan</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="gelar_depan" name="gelar_depan[]" value="<?= (isset($get->gelar_depan)) ? $get->gelar_depan : ''; ?>" placeholder="Gelar Depan"  />
    </div>
</div>
<div class="form-group row mode2">
    <label for="gelar_belakang" class="col-sm-3 col-form-label">Gelar Belakang</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang[]" value="<?= (isset($get->gelar_belakang)) ? $get->gelar_belakang : ''; ?>" placeholder="Gelar Belakang"  />
    </div>
</div>
<div class="form-group row mode2">
    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="alamat" name="alamat[]" value="<?= (isset($get->alamat)) ? $get->alamat : ''; ?>" placeholder="Alamat" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="pendidikan" class="col-sm-3 col-form-label">Pendidikan</label>
    <div class="col-sm-9 item">
        <?php $defaults = array(''=>'==Pilih Pendidikan==');
            $options = array(
				'S3'=>'S3',
				'S2'=>'S2',
				'S1/D4'=>'S1/D4',
				'D3'=>'D3',
				'D2'=>'D2',
				'D1'=>'D1',
				'SMA/SMK/MA'=>'SMA/SMK/MA',
			);  
            echo form_dropdown('pendidikan[]',$defaults + $options,(isset($get->pendidikan)) ? $get->pendidikan: '','class="form-control" id="pendidikan" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="lulusan" class="col-sm-3 col-form-label">Lulusan</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="lulusan" name="lulusan[]" value="<?= (isset($get->lulusan)) ? $get->lulusan : ''; ?>" placeholder="Lulusan"  />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />