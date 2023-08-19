<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group mode2">
    <label for="lab_id" class="col-form-label">Lab Id</label>
    <div class="item">
        <input type="text" class="form-control border" id="lab_id" name="lab_id[]" value="<?= (isset($get->lab_id)) ? $get->lab_id : ''; ?>" placeholder="Nama Laboratorium" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="nama_fasilitas" class="col-form-label">Nama Fasilitas</label>
    <div class="item">
        <input type="text" class="form-control border" id="nama_fasilitas" name="nama_fasilitas[]" value="<?= (isset($get->nama_fasilitas)) ? $get->nama_fasilitas : ''; ?>" placeholder="Nama Fasilitas" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="jumlah" class="col-form-label">Jumlah</label>
    <div class="item">
        <input type="number" min="0" class="form-control border" id="jumlah" name="jumlah[]" value="<?= (isset($get->jumlah)) ? $get->jumlah : ''; ?>" placeholder="Jumlah" required />
    </div>
</div>
<div class="form-group mode2">
    <label for="status" class="col-form-label">Status</label>
    <div class="item">
        <?php $defaults = array(''=>'==Pilih Status==');
            $options = array(
				'layak'=>'Layak',
				'tidak layak'=>'Tidak Layak',
			);  
            echo form_dropdown('status[]',$defaults + $options,(isset($get->status)) ? $get->status: '','class="form-control border" id="status" required');
        ?>
    </div>
</div>
<div class="form-group mode2">
    <label for="keterangan" class="col-form-label">Keterangan</label>
    <div class="item">
        <input type="text" class="form-control border" id="keterangan" name="keterangan[]" value="<?= (isset($get->keterangan)) ? $get->keterangan : ''; ?>" placeholder="Keterangan"  />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />