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
                    <button type="button" class="btn btn-success fst-italic" id="kirim" data-method="kirim" data-title="Kirim Data ini?" data-message="Anda Yakin Kirim Data Ini ke Verifikator?" disabled>Kirim</button>
                </div>
            </div>
            <table id="table" data-toggle="table" data-ajax="ajaxRequest" data-page-list="[10, 25, 50, 100, ALL]" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar" data-query-params="queryHarga">
                <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="id_bahan" data-visible="false">ID</th>
                        <th data-field="nomor">No</th>
                        <th data-field="nama">Nama</th>
                        <th data-field="harga">Harga</th>
                        <th data-field="satuan">Satuan</th>
                        <th data-field="ket" data-visible="false">Keterangan</th>
                        <th data-field="tanggal">Tanggal</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>