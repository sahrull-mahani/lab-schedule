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
            <?php if (in_groups([1, 2, 3])) : ?>
                <div id="toolbar">
                    <input type="number" class="btn btn-default border d-none" style="width: 100px;" value="1" min="1" id="number-of-row" readonly>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary create" method="create" data-toggle="modal"><?= is_admin() ? '<i class="fa fa-plus"></i> Buat Jadwal' : 'Ajukan Jadwal' ?></button>
                        <?php if (is_admin()) : ?>
                            <button type="button" class="btn btn-danger" id="remove" disabled><i class="fa fa-trash"></i> Hapus</button>
                            <button type="button" class="btn btn-success" id="approve" disabled><i class="fa fa-check"></i> Status</button>
                        <?php endif ?>
                        <!-- <button type="button" class="btn btn-warning" id="edit" method="edit" disabled><i class="fa fa-edit"></i> Pindah Jadwal</button> -->
                    </div>
                </div>
            <?php endif ?>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="table" data-toggle="table" data-ajax="ajaxRequest" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar">
                    <thead>
                        <tr>
                            <?php if (in_groups([1, 2, 3])) : ?>
                                <th data-field="state" data-radio="true"></th>
                                <th data-field="id" data-visible="false">ID</th>
                            <?php endif ?>
                            <th data-field="nomor">No</th>
                            <th data-field="dosen_id">Dosen</th>
                            <th data-field="ttdosen">Team Teaching</th>
                            <th data-field="mk_id">Mata Kuliah</th>
                            <th data-field="semester">Semester</th>
                            <th data-field="kelas_id">Kelas</th>
                            <th data-field="sks">SKS</th>
                            <th data-field="lab_id">Ruangan</th>
                            <th data-field="waktu_mulai">Waktu Mulai</th>
                            <th data-field="waktu_selesai">Waktu Selesai</th>
                            <?php if (in_groups([1, 2, 3])) : ?>
                                <th data-field="status">Status</th>
                            <?php endif ?>
                            <th data-field="hari">Hari</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>