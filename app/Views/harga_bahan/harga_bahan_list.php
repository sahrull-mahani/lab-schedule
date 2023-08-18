<?= $this->extend("template_adminlte/index") ?>
<?= $this->section("page-content") ?>

<div class="container-fluid py-4">
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3"><?= $breadcome ?></h6>
            </div>
        </div>
        <div class="card-body">
            <div id="toolbar">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <?= form_dropdown('year', ['pokok' => 'Bahan Pokok', 'penting' => 'Bahan Penting'], 'pokok', 'class="btn btn-primary fw-bold select classic primary" id="bahan"'); ?>
                    <?= form_dropdown('year', getYearHargaBahan(), date('Y'), 'class="btn btn-success select classic success" id="tahun"'); ?>
                    <?php $defaults = array('none' => 'Filter By Month');
                    echo form_dropdown('bulan', $defaults + getMonthHargaBahan(), '', 'class="btn btn-info select classic info" id="bulan"'); ?>
                    <?php if (in_groups(3)) : ?>
                        <button type="button" class="btn btn-success fst-italic" id="kirim" data-method="verifikasi" data-title="Verifikasi Data ini?" data-message="Anda Yakin Mem-verifikasi data ini?">Verifikasi</button>
                        <button type="button" class="btn btn-danger fst-italic" id="remove" disabled>Hapus</button>
                    <?php elseif (in_groups(4)) : ?>
                        <button type="button" class="btn btn-success fst-italic" id="kirim" data-method="approve" data-title="Setujui Data ini?" data-message="Anda Yakin Menyetujui data ini?">Approve</button>
                        <button type="button" class="btn btn-danger fst-italic" id="unverifikasi" disabled>Kembalikan</button>
                    <?php endif ?>
                </div>
            </div>
            <table id="table" data-toggle="table" data-ajax="ajaxRequest" data-page-list="[10, 25, 50, 100, ALL]" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar" data-query-params="queryHarga">
                <thead>
                    <tr>
                        <th data-field="id" data-visible="false">ID</th>
                        <th data-field="nomor">No</th>
                        <th data-field="bahan">Bahan</th>
                        <th data-field="nama">Nama</th>
                        <th data-field="nama_barang">Nama Barang</th>
                        <th data-field="harga">Harga</th>
                        <th data-field="satuan">Satuan</th>
                        <th data-field="tanggal">Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>