<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="input-group input-group-outline my-3">
    <?php if (count($pangkalan) > 0) : ?>
        <?php $defaults = array('' => '==Pilih Pangkalan==');
        foreach ($pangkalan as $row) {
            $options[$row->id] = $row->nama_pangkalan;
        }
        echo form_dropdown('pangkalan_id[]', $defaults + $options, @$get->pangkalan_id, 'class="form-control" id="pangkalan_id" required');
        ?>
    <?php else : ?>
        <select class="form-control" disabled required>
            <option selected disabled>Pangkalan Belum Dimasukan</option>
        </select>
    <?php endif ?>
</div>
<div class="input-group input-group-outline my-3">
    <div class="input-group input-group-dynamic">
        <input type="number" class="form-control" id="jumlah minggu" name="jumlah_perminggu[]" value="<?= @$get->jumlah ?>" placeholder="Jumlah Minggu" required />
        <input type="number" class="form-control" id="jumlah perbulan" name="jumlah_perbulan[]" value="<?= @$get->jumlah ?>" placeholder="Jumlah Perbulan" required />
    </div>
</div>
<div class="input-group input-group-outline my-3">
    <input type="number" class="form-control" id="jumlah_kk" name="jumlah_kk[]" value="<?= @$get->jumlah_kk ?>" placeholder="Jumlah KK Contoh:10" required />
</div>
<input type="hidden" name="id[]" value="<?= @$get->id ?>" />