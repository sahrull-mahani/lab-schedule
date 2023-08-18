<h1 align="center"><?= getBulan($bulan, 'number') . ' ' . $tahun ?></h1>
<h3 align="center"><?= getBulan($bulan, 'number') . ' ' . $tahun ?></h3>
<table border="1" class="reset-table tb-100">
    <tr>
        <td rowspan="2" align="center">URAIAN</td>
        <td rowspan="2" align="center">SATUAN</td>
        <td colspan="<?= count($hasil) ?>" align="center">HARGA</td>
    </tr>
    <tr>
        <?php foreach ($hasil as $key => $val) : ?>
            <?php $key++ ?>
            <td align="center"><?= "Minggu $key" ?></td>
        <?php endforeach ?>
    </tr>
    <?php foreach ($nama as $key => $row) : ?>
        <tr>
            <td><?= ucwords($row->nama_barang) ?></td>
            <td><?= $satuan[$key]->satuan ?></td>
            <?php foreach ($hasil as $k => $val) : ?>
                <td>
                    <?= $hasil[$k] !== null ? rupiah(explode(',',$val['harga'])[$key]) : 0?>
                </td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
</table>