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
                <?php $defaults = array('none' => 'Filter By kecamatan');
                        echo form_dropdown('kecamatan', $defaults + getKodeKec(2), '', 'class="btn btn-info select classic info" id="kecamatan"'); ?>
                    <?= form_dropdown('year', getYearKuota(), date('Y'), 'class="btn btn-success select classic success" id="tahun"'); ?>
                    <?php $defaults = array('none' => 'Filter By Month');
                    echo form_dropdown('bulan', $defaults + getMonthKuota(), date('m'), 'class="btn btn-info select classic info" id="bulan"'); ?>
                    <?php if (!is_admin() && in_groups(4)) : ?>
                        <button type="button" class="btn btn-primary" id="approve" method="approve" disabled><i class="fa fa-plus"></i> Setujui laporan</button>
                    <?php endif ?>
                    <button type="button" class="btn btn-primary" id="print" method="print" disabled><i class="material-icons opacity-10">print</i></button>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="table" data-toggle="table" data-ajax="ajaxRequest" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar" data-query-params="queryPangkalan">
                    <thead>
                        <tr>
                            <th data-field="id" data-visible="false">ID</th>
                            <th data-field="nomor">No</th>
                            <th data-field="pangkalan_id">Pangkalan</th>
                            <th data-field="jumlah-perminggu">Jumlah Perminggu</th>
                            <th data-field="jumlah-perbulan">Jumlah Perbulan</th>
                            <th data-field="jumlah-kk">Jumlah Kepala Keluarga</th>
                            <th data-field="bulan">Bulan</th>
                            <th data-field="status">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>