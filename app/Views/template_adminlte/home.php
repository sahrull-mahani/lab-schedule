<?= $this->extend('template_adminlte/index') ?>
<?= $this->section('page-content') ?>
<div class="container-fluid py-4">
    <div class="row">

        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">biotech</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Laboratorium</p>
                        <h4 class="mb-0"><?= $lab ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> -->
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">meeting_room</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Kelas</p>
                        <h4 class="mb-0"><?= $kelas ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p> -->
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-xl-0 my-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">library_books</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Mata Kuliah</p>
                        <h4 class="mb-0"><?= $mk ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p> -->
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-sm-12 mb-xl-0 mt-5">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Jadwal</h6>
                    </div>
                    <div class="card-body">
                        <div id="toolbar">
                            <?php if (in_groups([1, 2])) : ?>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="<?= site_url('home/export_pdf') ?>" target="_blank" class="btn btn-primary">Laporan</a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="table" data-toggle="table" data-ajax="ajaxRequest" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="nomor">No</th>
                                        <th data-field="dosen_id">Dosen</th>
                                        <th data-field="ttdosen_id">Team Teaching</th>
                                        <th data-field="mk_id">Mata Kuliah</th>
                                        <th data-field="kelas_id">Kelas</th>
                                        <th data-field="lab_id">Laboratorium</th>
                                        <th data-field="sks">SKS</th>
                                        <th data-field="semester">Semester</th>
                                        <th data-field="waktu_mulai">Waktu Mulai</th>
                                        <th data-field="waktu_selesai">Waktu Selesai</th>
                                        <th data-field="hari">Hari</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>