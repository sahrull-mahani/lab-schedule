<div class="form-group mode2">
    <label for="waktu_mulai" class="col-form-label">Waktu Mulai</label>
    <div class="item">
        <input type="time" class="form-control border range-time-start" data-min="<?= $time ?>" min="08:00" max="16:00" step="900" id="waktu_mulai" name="waktu_mulai[]" value="<?= @$get->waktu_mulai ?>" placeholder="Waktu Mulai" required />
    </div>
</div>
<div class="form-group mode2" style="display: none;">
    <label for="waktu_selesai" class="col-form-label">Waktu Selesai</label>
    <div class="item">
        <input type="time" class="form-control border" id="waktu_selesai" min="09:00" max="17:00" step="900" name="waktu_selesai[]" value="<?= @$get->waktu_selesai ?>" placeholder="Waktu Selesai" required disabled />
    </div>
</div>

<script>
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
            if (times != null || times != undefined || times != '') {
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