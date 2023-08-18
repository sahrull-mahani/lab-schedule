<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title ?></title>
  <meta content="WEBSITE KOMINFO PERSANDIAN BMU" name="description">
  <meta content="Diskominfo Bolmut" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url('assets/dist/img/logo-bolmut.png') ?>" rel="icon">
  <link href="<?= site_url('assets/dist/img/logo-bolmut.png'); ?>" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- lightbox -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

  <!-- kartik file upload -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
  <!-- Bootstrap Data Table -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-data-table/bootstrap-table.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-data-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-data-table/extensions/resizable/jquery.resizableColumns.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Plugins -->
  <link href="<?= site_url('assets/plugins/lobibox/lobibox.min.css') ?>" rel="stylesheet">

  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

  <!-- Nucleo Icons -->
  <link href="<?= site_url('admin-assets/css/nucleo-icons.css') ?>" rel="stylesheet" />
  <link href="<?= site_url('admin-assets/css/nucleo-svg.css') ?>" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

  <!-- CSS Files -->
  <link id="pagestyle" href="<?= site_url('admin-assets/css/material-dashboard.css?v=3.1.0') ?>" rel="stylesheet" />

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

  <!-- Custom Style -->
  <link rel="stylesheet" href="<?= site_url('assets/dist/css/style.css') ?>">

  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <?= $this->include('template_adminlte/sidebar') ?>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?= $this->include('template_adminlte/topbar') ?>
    <?= $this->renderSection('page-content') ?>
  </main>

  <div id="spinner" style="position:fixed; top: 50%; left: 50%; margin-left: -50px; margin-top: -50px;z-index: 999999;display: none;">
    <span>Loading...</span> <br>
    <img src="<?= base_url('assets/dist/img/ring.gif') ?>" />
  </div>

  <div id="modal_content" class="modal fade" tabindex="-1" data-bs-backdrop="false" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="modal-size">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">highlight_off</i></button>
        </div>
        <div class="isi-modal"></div>
      </div>
    </div>
  </div>

  <!-- SETTINGs -->
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ENDSETTINGs -->

  <!-- JQUERY -->
  <script src="<?= site_url('assets/plugins/jquery/jquery.min.js') ?>"></script>

  <!--   Core JS Files   -->
  <script src="<?= site_url('admin-assets/js/core/popper.min.js') ?>"></script>
  <script src="<?= site_url('admin-assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?= site_url('admin-assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
  <script src="<?= site_url('admin-assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
  <script src="<?= site_url('admin-assets/js/plugins/chartjs.min.js') ?>"></script>

  <!-- datatables -->
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <!-- Bootstrap Data Table -->
  <script src="<?= base_url('assets/plugins/bootstrap-data-table/bootstrap-table.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/bootstrap-data-table/extensions/editable/bootstrap-table-editable.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/bootstrap-data-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js') ?>"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.2/extensions/resizable/bootstrap-table-resizable.min.js"></script> -->
  <!-- kartik file upload -->
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/fileinput.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>
  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
  <!-- Swetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- lightbox -->
  <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>
  <!-- summernote -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <!-- lobibox -->
  <script src="<?= site_url('assets/plugins/lobibox/lobibox.js') ?>"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url('assets/dist/js/validator.js') ?>"></script>
  <script src="<?= site_url('assets/dist/js/main.js') ?>"></script>

  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= site_url('admin-assets/js/material-dashboard.min.js?v=3.1.0') ?>"></script>

  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Custom Script -->
  <script src="<?= site_url('assets/dist/js/custom.js') ?>"></script>
  <?php if (isset($chart)) : ?>
    <script src="<?= site_url('assets/dist/js/my-chart.js') ?>"></script>
  <?php endif ?>
</body>

</html>