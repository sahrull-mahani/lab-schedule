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
            <div class="btn-group" role="group" aria-label="Basic example">
                <?= form_dropdown('year', getYearHargaBahan(), date('Y'), 'class="btn btn-success select classic success" id="tahun"'); ?>
                <?= form_dropdown('year', ['pokok' => 'Bahan Pokok', 'penting' => 'Bahan Penting'], 'pokok', 'class="btn btn-primary fw-bold select classic primary" id="bahan"'); ?>
                <?= form_dropdown('bulan', getMonthHargaBahan(), array_key_first(getMonthHargaBahan()), 'class="btn btn-info fw-bold select classic info" id="month"'); ?>
                <button type="button" class="btn btn-success fst-italic" id="single-print" data-method="print" data-title="Print Data" data-message="Anda yakin print data ini?">Print</button>
            </div>
            <select class="select2-multiple mb-5" id="select-bahan" multiple style="width: 100%;"></select>
            <div class="shadow-primary border-radius-lg py-3 pe-1 mt-4">
                <div class="chart">
                    <canvas id="mixed-chart" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>