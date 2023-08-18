<table class="reset-table tb-100 text-center">
    <tr>
        <td>
            <h3>PEMERINTAH KABUPATEN BOLAANG MONGONDOW UTARA</h3>
            <h3>SEKRETARIAT DAERAH</h3>
            <h3>LIQUEFIED PETROLEUM GAS (LPG) 3 Kg</h3>
            <h3>TAHUN <?= date('Y') ?></h3>
        </td>
    </tr>
</table>

<div class="mb-1"></div>

<table border="1" class="reset-table tb-50 text-center">
    <tr>
        <td colspan="3">AGEN LPG 4 Kg BOROKO</td>
    </tr>
    <tr>
        <td>NAMA PERUSAHAAN</td>
        <td>ALAMAT PERUSAHAAN</td>
        <td>NOMOR SPBU</td>
    </tr>
    <tr>
        <td>PT. ECOGAS INTI ALAM</td>
        <td>Jln. Trans Sulawesi</td>
        <td>822203</td>
    </tr>
</table>

<div class="mt-1"></div>

<table border="1" class="reset-table tb-100">
    <tr>
        <td class="text-center" style="font-weight: bold;" colspan="8">KECAMATAN <?= strtoupper($kecamatan) ?></td>
    </tr>
    <tr>
        <td style="height: 50px;">NO</td>
        <td>NAMA PANGKALAN</td>
        <td>ALAMAT PANGKALAN</td>
        <td>ID REGISTRASI</td>
        <td>JUMLAH KUOTA PERMINGGU</td>
        <td>JUMLAH KUOTA PERBULAN</td>
        <td>JUMLAH KEPALA KELUARGA</td>
        <td>KET</td>
    </tr>
    <?php foreach ($data as $key => $row) : ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $row->nama_pangkalan ?></td>
            <td><?= getDesa($row->desa_id)->nama ?></td>
            <td><?= $row->id_registrasi ?></td>
            <td align="center"><?= $row->jumlah_perminggu ?></td>
            <td><?= $row->jumlah_perbulan ?></td>
            <td><?= $row->jumlah_kk ?></td>
            <td></td>
        </tr>
    <?php endforeach ?>
</table>