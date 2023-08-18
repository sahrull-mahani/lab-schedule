<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="input-group input-group-outline my-3 kecamatan" data-key="<?= $key ?>" data-desa="<?= @$desa_id ?>">
    <label class="form-label">Kecamatan</label>
    <select class="form-control"></select>
</div>
<div class="input-group input-group-outline my-3">
    <label class="form-label">Desa</label>
    <select class="form-control" id="desa_id" name="desa_id[]" required disabled></select>
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="nama_pangkalan" name="nama_pangkalan[]" value="<?= @$get->nama_pangkalan ?>" placeholder="Nama Pangkalan" required />
</div>
<div class="input-group input-group-outline my-3">
    <input type="text" class="form-control" id="id_registrasi" name="id_registrasi[]" value="<?= @$get->id_registrasi ?>" placeholder="ID Regristrasi Cnth: 782120...." required />
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />

<script>
    var desa_id = $('.kecamatan').data('desa')
    $.getJSON('https://ibnux.github.io/data-indonesia/kecamatan/7108.json', function(res) {
        $('.kecamatan').find('label').text('')
        $('.kecamatan').find('select').append('<option value="" selected disabled>==Pilih Kecamatan==</option>')
        for (let i = 0; i < res.length; i++) {
            $('.kecamatan').find('select').append(`<option value="${res[i].id}" ${res[i].id == String(desa_id).substring(0, 6) ? 'selected' : ''}>${res[i].nama}</option>`)
        }
    })

    if (desa_id != '') {
        var kec_id = String(desa_id).substring(0, 6)
        $('.kecamatan').next().find('select').removeAttr('disabled')
        $('.kecamatan').next().find('select').append('<option selected disabled>==Pilih Desa==</option>')
        $('.kecamatan').next().find('label').text('')
        $.getJSON(`https://ibnux.github.io/data-indonesia/kelurahan/${kec_id}.json`, function(res) {
            for (let i = 0; i < res.length; i++) {
                $('.kecamatan').next().find('select').append(`<option value="${res[i].id}" ${res[i].id == desa_id ? 'selected' : ''}>${res[i].nama}</option>`)
            }
        })
    }
    $('.kecamatan').on('change', function() {
        let val = $(this).find('select').val()
        let key = $(this).data('key')
        $(this).next().find('select').empty()
        $(this).next().find('select').removeAttr('disabled')
        $(this).next().find('select').append('<option selected disabled>==Pilih Desa==</option>')
        $(this).next().find('label').text('')
        $.getJSON(`https://ibnux.github.io/data-indonesia/kelurahan/${val}.json`, function(res) {
            for (let i = 0; i < res.length; i++) {
                $(`.kecamatan[data-key=${key}]`).next().find('select').append(`<option value="${res[i].id}">${res[i].nama}</option>`)
            }
        })
    })
</script>