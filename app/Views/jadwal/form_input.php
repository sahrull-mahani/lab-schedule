<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<?php if (is_admin()) : ?>
    <div class="form-group mode2">
        <label for="dosen_id" class="col-form-label">Dosen</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Dosen==');
            foreach ($dosen as $row) {
                $dosens[$row->id] = $row->nama_penjabat;
            }
            echo form_dropdown('dosen_id[' . ($key - 1) . '][]', $defaults + ($dosens ?? []), @$get->dosen_id, 'class="select2" multiple id="dosen_id" required');
            ?>
        </div>
    </div>
    <?php if ($aksi == 'edit') : ?>
        <!-- <div class="form-group mode2">
            <label for="dosen_id" class="col-form-label">Dosen Pengganti</label>
            <div class="item">
                <?php //$defaults = array('' => '==Pilih Dosen Pengganti==');
                // foreach ($dosen as $row) {
                //     $dosens[$row->id] = $row->nama_penjabat;
                // }
                // echo form_dropdown('dosen_verify[]', $defaults + ($dosens ?? []), '', 'class="form-control border" id="dosen_verify"');
                ?>
            </div>
        </div> -->
    <?php endif ?>
<?php else : ?>
    <div class="form-group mode2">
        <label for="dosen_id" class="col-form-label">Dosen Team Teaching</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Team Teaching==');
            foreach ($dosen as $row) {
                if ($row->id == session('id_peg')) continue;
                $dosens[$row->id] = $row->nama_penjabat;
            }
            echo form_dropdown('dosen_id[' . ($key - 1) . '][]', $defaults + ($dosens ?? []), @$get->dosen_id, 'class="select2" id="dosen_id" required');
            ?>
        </div>
    </div>
    <?php if ($aksi == 'edit' && $get->dosen_id != session('id_peg')) : ?>
        <!-- <div class="form-group mode2">
            <label for="dosen_id" class="col-form-label">Tukar Jadwal</label>
            <div class="item">
                <?php //$defaults = array('' => '==Pilih Tukar Jadwal atau Tidak==');
                // $options = [
                //     'tukar' => 'Tukar'
                // ];
                // echo form_dropdown('dosen_verify[]', $defaults + $options, '', 'class="form-control border" id="dosen_verify"');
                ?>
            </div>
        </div> -->
    <?php endif ?>
<?php endif ?>

<?php if ($aksi != 'edit' || is_admin() || $get->dosen_id == session('id_peg')) : ?>
    <div class="form-group mode2">
        <label for="mk_id" class="col-form-label">Mata Kuliah</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Mata Kuliah==');
            foreach ($matakuliah as $row) {
                $mks[$row->id] = $row->nama_mk;
            }
            echo form_dropdown('mk_id[]', $defaults + ($mks ?? []), @$get->mk_id, 'class="form-control border" id="mk_id" required');
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
            echo form_dropdown('kelas_id[]', $defaults + ($kelass ?? []), @$get->kelas_id, 'class="form-control border" id="kelas_id" required');
            ?>
        </div>
    </div>
    <div class="form-group mode2">
        <label for="lab_id" class="col-form-label">Ruangan</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Ruangan==');
            foreach ($laboratorium as $row) {
                $labs[$row->id] = $row->nama_lab;
            }
            echo form_dropdown('lab_id[]', $defaults + ($labs ?? []), @$get->lab_id, 'class="form-control border" id="lab_id" required');
            ?>
        </div>
    </div>
    <div class="form-group mode2">
        <label for="semester" class="col-form-label">Semester</label>
        <div class="item">
            <input type="text" class="form-control border" id="semester" name="semester[]" value="<?= @$get->semester ?>" placeholder="Semester..." required />
        </div>
    </div>
    <div class="form-group mode2">
        <label for="sks" class="col-form-label">SKS</label>
        <div class="item">
            <input type="text" class="form-control border" id="sks" name="sks[]" value="<?= @$get->sks ?>" placeholder="SKS..." required />
        </div>
    </div>
    <div class="form-group mode2">
        <label for="waktu_mulai" class="col-form-label">Waktu Mulai</label>
        <div class="item">
            <input type="time" class="form-control border" min="08:00" max="16:00" step="900" id="waktu_mulai" name="waktu_mulai[]" value="<?= @$get->waktu_mulai ?>" placeholder="Waktu Mulai" required />
        </div>
    </div>
    <div class="form-group mode2">
        <label for="waktu_selesai" class="col-form-label">Waktu Selesai</label>
        <div class="item">
            <input type="time" class="form-control border" id="waktu_selesai" min="09:00" max="17:00" step="900" name="waktu_selesai[]" value="<?= @$get->waktu_selesai ?>" placeholder="Waktu Selesai" required />
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
            echo form_dropdown('hari[]', $defaults + $options, @$get->hari, 'class="form-control border" id="hari" required');
            ?>
        </div>
    </div>
<?php endif ?>
<input type="hidden" name="id[]" value="<?= @$get->id ?>" />

<script>
    function selectItem(target, id) { // refactored this a bit, don't pay attention to this being a function
        var option = $(target).children('[value=' + id + ']');
        option.detach();
        $(target).append(option).change();
    }

    function customPreSelect() {
        let items = $('#selected_items').val().split(',');
        $("select").val('').change();
        initSelect(items);
    }

    function initSelect(items) { // pre-select items
        items.forEach(item => { // iterate through array of items that need to be pre-selected
            let value = $('select option[value=' + item + ']').text(); // get items inner text
            $('select option[value=' + item + ']').remove(); // remove current item from DOM
            $('select').append(new Option(value, item, true, true)); // append it, making it selected by default
        });
    }
    $('.select2 option:first').attr('selected', false)
    $('.select2 option:first').attr('disabled', true)
    $('.select2').select2({
        width: '100%',
        maximumSelectionLength: 2,
    })
    $('.select2').on('select2:select', function(e) {
        selectItem(e.target, e.params.data.id)
    })
</script>