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
        <label for="sks" class="col-form-label">SKS</label>
        <div class="item">
            <input type="text" class="form-control border" id="sks" name="sks[]" value="<?= @$get->sks ?>" placeholder="SKS..." required />
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
    <div class="form-group mode2" style="display: none;">
        <label for="semester" class="col-form-label">Semester</label>
        <div class="item">
            <input type="text" class="form-control border" id="semester" name="semester[]" value="<?= @$get->semester ?>" placeholder="Semester..." required disabled />
        </div>
    </div>
    <div class="form-group mode2" style="display: none;">
        <label for="lab_id" class="col-form-label">Ruangan</label>
        <div class="item">
            <?php $defaults = array('' => '==Pilih Ruangan==');
            foreach ($laboratorium as $row) {
                $labs[$row->id] = $row->nama_lab;
            }
            echo form_dropdown('lab_id[]', $defaults + ($labs ?? []), @$get->lab_id, 'class="form-control border" id="lab_id" required disabled');
            ?>
        </div>
    </div>
    <div class="form-group mode2" style="display: none;">
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
            echo form_dropdown('hari[]', $defaults + $options, @$get->hari, 'class="form-control border" id="hari" required disabled');
            ?>
        </div>
    </div>
    <div class="form-group mode2" style="display: none;">
        <label for="waktu_mulai" class="col-form-label">Waktu Mulai</label>
        <div class="item">
            <input type="time" class="form-control border range-time-start" min="08:00" max="16:00" step="900" id="waktu_mulai" name="waktu_mulai[]" value="<?= @$get->waktu_mulai ?>" placeholder="Waktu Mulai" required disabled />
        </div>
    </div>
    <div class="form-group mode2" style="display: none;">
        <label for="waktu_selesai" class="col-form-label">Waktu Selesai</label>
        <div class="item">
            <input type="time" class="form-control border" id="waktu_selesai" min="09:00" max="17:00" step="900" name="waktu_selesai[]" value="<?= @$get->waktu_selesai ?>" placeholder="Waktu Selesai" required disabled />
        </div>
    </div>
<?php endif ?>
<input type="hidden" name="id[]" value="<?= @$get->id ?>" />

<script>
    $('.timepicker').timepicker()

    function selectItem(target, id) { // refactored this a bit, don't pay attention to this being a function
        var option = $(target).children('[value=' + id + ']')
        option.detach()
        $(target).append(option).change()
    }

    function customPreSelect() {
        let items = $('#selected_items').val().split(',')
        $("select").val('').change()
        initSelect(items)
    }

    function initSelect(items) { // pre-select items
        items.forEach(item => { // iterate through array of items that need to be pre-selected
            let value = $('select option[value=' + item + ']').text() // get items inner text
            $('select option[value=' + item + ']').remove() // remove current item from DOM
            $('select').append(new Option(value, item, true, true)) // append it, making it selected by default
        })
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

    $('#dosen_id').on('change', function() {
        let totalselect = $(this).val().length

        if (totalselect == 2) {
            $('#semester').parent().parent().show('slow')
            $('#semester').removeAttr('disabled')
        } else {
            $('#semester').parent().parent().hide('fast')
            $('#semester').val('')
            $('#semester').attr('disabled')
            $('#lab_id').parent().parent().hide('fast')
            $('#lab_id').attr('disabled')
            $('#lab_id').val('')
            $('#hari').attr('disabled')
            $('#hari option:first').prop('selected', true)
            $('#hari').parent().parent().hide('fast')
            $('#waktu_mulai').parent().parent().hide('fast')
            $('#waktu_mulai').attr('disabled')
            $('#waktu_mulai').val('')
            $('#waktu_selesai').parent().parent().hide('fast')
            $('#waktu_selesai').attr('disabled')
            $('#waktu_selesai').val('')
        }
    })

    function convertTimeToTimestamp(timeString) {
        // Create a new Date object with the current date and the provided time string
        const date = new Date()
        date.setHours(timeString.split(":")[0])
        date.setMinutes(timeString.split(":")[1])
        return date.getTime()
    }

    $('#semester').on('change', function() {
        $('#lab_id').removeAttr('disabled')
        $('#lab_id').parent().parent().show('slow')
        $('#lab_id').val('')

        $('#hari').attr('disabled')
        $('#hari option:first').prop('selected', true)
        $('#hari').parent().parent().hide('fast')
        $('#waktu_mulai').parent().parent().hide('fast')
        $('#waktu_mulai').attr('disabled')
        $('#waktu_mulai').val('')
        $('#waktu_selesai').parent().parent().hide('fast')
        $('#waktu_selesai').attr('disabled')
        $('#waktu_selesai').val('')
    })

    $('#lab_id option:first').attr('selected', false)
    $('#lab_id option:first').attr('disabled', true)
    $('#lab_id').on('change', function() {
        $('#hari').removeAttr('disabled')
        $('#hari').parent().parent().show('slow')

        $.post({
            url: location.origin + '/jadwal/getOrderTime',
            data: {
                by: 'lab',
                semester: $('#semester').val(),
                lab: $(this).val()
            },
            dataType: 'json',
            success: function(res) {
                $('#hari').empty()
                $('#hari').append(`<option value="" selected disabled>-- Pilih Hari --</option>`)
                res.message.forEach(day => {
                    $('#hari').append(`<option value="${day.day}" ${day.full ? 'disabled' : ''}>${day.day}</option>`)
                })
                $('#waktu_mulai').attr('disabled')
                $('#waktu_mulai').val('')
                $('#waktu_mulai').parent().parent().hide('fast')
                $('#waktu_selesai').attr('disabled')
                $('#waktu_selesai').val('')
                $('#waktu_selesai').parent().parent().hide('fast')
            },
            error: function(xhr, status, errorThrown) {
                const {
                    message
                } = xhr.responseJSON
                alert(message)
            }
        })

    })

    $('#hari option:first').attr('selected', false)
    $('#hari option:first').attr('disabled', true)
    $('#hari').on('change', function() {
        $('#waktu_mulai').removeAttr('disabled')
        $('#waktu_mulai').parent().parent().show('slow')
        $.post({
            url: location.origin + '/jadwal/getOrderTime',
            data: {
                by: 'hari',
                semester: $('#semester').val(),
                dosen: $('#dosen_id').val(),
                hari: $(this).val()
            },
            dataType: 'json',
            success: function(res) {
                min = res.result
                $('#waktu_mulai').attr('data-min', min)
                $('#waktu_selesai').attr('disabled')
                $('#waktu_selesai').val('')
                $('#waktu_selesai').parent().parent().hide('fast')
            },
            error: function(xhr, status, errorThrown) {
                const {
                    message
                } = xhr.responseJSON
                alert(message)
            }
        })
    })

    $('#waktu_mulai').on('change', function(e) {
        e.preventDefault()
        let isValid = true
        const timevalue = convertTimeToTimestamp($(this).val())
        const times = $(this).data('min')

        const timemin = convertTimeToTimestamp($(this).attr('min'))
        const timemax = convertTimeToTimestamp($(this).attr('max'))

        if (timevalue != NaN) {
            if (timevalue < timemin) {
                alert('Minimal jam ' + $(this).attr('min'))
                isValid = false
                return $(this).val('')
            }
            if (timevalue == convertTimeToTimestamp('12:00:00')) {
                alert('Jam istirahat')
                isValid = false
                return $(this).val('')
            }
            if (timevalue > timemax) {
                alert('Maximal jam ' + $(this).attr('max'))
                isValid = false
                return $(this).val('')
            }
            if (times != null) {
                times.split('|').forEach(time => {
                    if (timevalue >= convertTimeToTimestamp(time.split(',')[0]) && timevalue < convertTimeToTimestamp(time.split(',')[1])) {
                        alert('Dari ' + time.split(',')[0] + ' sampai ' + time.split(',')[1] + ' sudah dipakai!')
                        isValid = false
                        return $(this).val('')
                    }
                })
            }
        }

        if (isValid) {
            $('#waktu_selesai').parent().parent().show('slow')
            $('#waktu_selesai').removeAttr('disabled')
            const waktuselesai = new Date(convertTimeToTimestamp($(this).val()) + (60 * 30) * 1000)
            $('#waktu_selesai').attr('min', waktuselesai.getHours().toString() + ':' + waktuselesai.getMinutes().toString())
        }
    })

    $('#waktu_selesai').on('change', function() {
        let isValid = true
        const timevalue = convertTimeToTimestamp($(this).val())
        const times = $('#waktu_mulai').data('min')

        const timemin = convertTimeToTimestamp($(this).attr('min'))
        const timemax = convertTimeToTimestamp($(this).attr('max'))

        if (timevalue != NaN) {
            if (timevalue < timemin) {
                alert('Minimal jam ' + $(this).attr('min'))
                isValid = false
                return $(this).val('')
            }
            if (timevalue > timemax) {
                alert('Maximal jam ' + $(this).attr('max'))
                isValid = false
                return $(this).val('')
            }
            if (times != null) {
                times.split('|').forEach(time => {
                    if (timevalue >= convertTimeToTimestamp(time.split(',')[0]) && timevalue < convertTimeToTimestamp(time.split(',')[1])) {
                        alert('Dari ' + time.split(',')[0] + ' sampai ' + time.split(',')[1] + ' sudah dipakai!')
                        isValid = false
                        return $(this).val('')
                    }
                })
            }
        }
    })
</script>