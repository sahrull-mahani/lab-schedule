<?= $this->extend('template_adminlte/index') ?>

<?= $this->section('page-content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $breadcome ?></h1>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><?= $breadcome ?></li>
    </ol>
</div>

<div class="card shadow mb-4">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Data <?= $breadcome ?></h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div id="toolbar">
                <input type="number" class="btn border btn-default" value="1" id="number-of-row">
                <button type="button" class="btn btn-primary create" method="create" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
                <button type="button" class="btn btn-warning" id="edit" method="edit" disabled><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-danger" id="remove" disabled><i class="fa fa-trash"></i> Hapus</button>
            </div>
            <table id="table" data-toggle="table" data-ajax="ajaxRequest" data-side-pagination="server" data-pagination="true" data-search="true" data-show-columns="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="id" data-visible="false">ID</th>
                        <th data-field="nomor">No</th>
                        <th data-field="nama" data-sortable="true">Nama</th>
                        <th data-field="jab_id" data-sortable="true">Jabatan</th>
                        <th data-field="jk">Jenis Kelamin</th>
                        <th data-field="tempat_lahir">Tempat Lahir</th>
                        <th data-field="tgl_lahir">Tanggal Lahir</th>
                        <th data-field="gelar_depan">Gelar Depan</th>
                        <th data-field="gelar_belakang">Gelar Belakang</th>
                        <th data-field="alamat">Alamat</th>
                        <th data-field="pendidikan">Pendidikan</th>
                        <th data-field="lulusan">Lulusan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>