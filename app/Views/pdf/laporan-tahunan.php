<div class="font">
    <h3 class="text-center m-0">JADWAL PERKULIAHAN SEMESTER GENAP TAHUN AKADEMIK <?= date('Y') . ' - ' . date('Y', strtotime('+1 year', strtotime(date('Y-m-d')))) ?></h3>
    <h3 class="text-center m-0">ROGRAM STUDI SISTEM INFORMASI</h3>
    <h3 class="text-center m-0">FAKULTAS SAINS DAN ILMU KOMPUTER</h3>
    <h3 class="text-center m-0">UNIVERSITAS MUHAMMADIYAH GORONTALO</h3>

    <br>

    <table class="tb-100 reset-table bordered tb-center" style="font-family: Arial; font-size: 10pt;">
        <tr style="background-color: rgba(0, 100, 255, .3);">
            <th rowspan="2">NO</th>
            <th rowspan="2">HARI</th>
            <th colspan="3">Jam</th>
            <th rowspan="2" width="50">DURASI WAKTU</th>
            <th rowspan="2" width="30">SEM</th>
            <th rowspan="2">KODE MK</th>
            <th rowspan="2" width="150">MATA KULIAH</th>
            <th rowspan="2" width="320">DOSEN PENGAMPU</th>
            <th rowspan="2" width="10">SKS</th>
            <th rowspan="2" width="50">RUANGAN</th>
        </tr>
        <tr style="background-color: rgba(0, 100, 255, .3);">
            <th>Mulai</th>
            <th>&nbsp;</th>
            <th>Selesai</th>
        </tr>
        <?php if (empty($jadwal)) : ?>
            <tr>
                <td colspan="12" align="center">KOSONG...!!!</td>
            </tr>
        <?php endif ?>

        <?php if (!empty($jadwal)) : ?>
            <?php foreach ($jadwal as $key => $row) : ?>
                <tr>
                    <td rowspan="2"><?= $key + 1 ?></td>
                    <td rowspan="2"><?= strtoupper($row->hari) ?></td>
                    <td rowspan="2"><?= date('H:i', strtotime($row->waktu_mulai)) ?></td>
                    <td rowspan="2">-</td>
                    <td rowspan="2"><?= date('H:i', strtotime($row->waktu_selesai)) ?></td>
                    <td rowspan="2"><?= date_diff(date_create($row->waktu_mulai), date_create($row->waktu_selesai))->format('%h.%i') ?></td>
                    <td rowspan="2"><?= $row->semester ?></td>
                    <td rowspan="2"><?= $row->kode_mk ?></td>
                    <td rowspan="2"><?= $row->nama_mk ?></td>
                    <td><?= pegawaiByID($row->dosen_id)->nama_penjabat ?></td>
                    <td rowspan="2"><?= $row->sks ?></td>
                    <td rowspan="2"><?= $row->nama_lab ?></td>
                </tr>
                <tr>
                    <td><?= pegawaiByID($row->dosentt_id)->nama_penjabat ?></td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>
</div>