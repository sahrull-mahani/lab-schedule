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
                    <input type="number" class="btn btn-default border" style="width: 100px;" value="1" min="1" id="number-of-row">
                    <button type="button" class="btn btn-primary create" method="create" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
                    <button type="button" class="btn btn-warning" id="edit" method="edit" disabled><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-danger" id="remove" disabled><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="table" data-toggle="table" data-ajax="ajaxRequest" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar">
                    <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="id" data-visible="false">ID</th>
                            <th data-field="nomor">No</th>
                            <th data-field="nama_mk">Mata Kuliah</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>