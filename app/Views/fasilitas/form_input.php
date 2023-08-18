<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group row mode2">
    <label for="lab" class="col-sm-3 col-form-label">Lab</label>
    <div class="col-sm-9 item">
        <?php $defaults = array(''=>'==Pilih Lab==');
            $options = array(
				'A'=>'A',
				'B'=>'B',
			);  
            echo form_dropdown('lab[]',$defaults + $options,(isset($get->lab)) ? $get->lab: '','class="form-control" id="lab" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="nama_fasilitas" class="col-sm-3 col-form-label">Nama Fasilitas</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas[]" value="<?= (isset($get->nama_fasilitas)) ? $get->nama_fasilitas : ''; ?>" placeholder="Nama Fasilitas" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="jumlah" name="jumlah[]" value="<?= (isset($get->jumlah)) ? $get->jumlah : ''; ?>" placeholder="Jumlah" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="status" class="col-sm-3 col-form-label">Status</label>
    <div class="col-sm-9 item">
        <?php $defaults = array(''=>'==Pilih Status==');
            $options = array(
				'layak'=>'layak',
				'tidak layak'=>'tidak layak',
			);  
            echo form_dropdown('status[]',$defaults + $options,(isset($get->status)) ? $get->status: '','class="form-control" id="status" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="keterangan" name="keterangan[]" value="<?= (isset($get->keterangan)) ? $get->keterangan : ''; ?>" placeholder="Keterangan"  />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />