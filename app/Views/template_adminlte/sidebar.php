<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="/" target="_blank">
        <img src="<?= site_url('assets/dist/img/logo-bolmut.png') ?>" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">LPG INFLASI</span>
    </a>
</div>
<hr class="horizontal light mt-0 mb-2">
<div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white <?= @$m_home ?>" href="/">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">dashboard</i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu LPG</h6>
        </li>

        <?php if (is_admin()) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_pangkalan ?>" href="<?= site_url('pangkalan') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_business</i>
                    </div>
                    <span class="nav-link-text ms-1">Pangkalan</span>
                </a>
            </li>
        <?php endif ?>

        <?php if (in_groups(2)) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_kuota ?>" href="<?= site_url('kuota-lpg') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dataset</i>
                    </div>
                    <span class="nav-link-text ms-1">Kuota LPG</span>
                </a>
            </li>
        <?php endif ?>

        <?php if (!is_admin() && in_groups(3)) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_verifikator ?>" href="<?= site_url('verifikator') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">playlist_add_check</i>
                    </div>
                    <span class="nav-link-text ms-1">Verifikasi Data</span>
                </a>
            </li>
        <?php endif ?>

        <?php if (!is_admin() && in_groups(4)) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_laporan ?>" href="<?= site_url('laporan') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Menu Inflasi</h6>
        </li>

        <?php if (in_groups(2)) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_harga ?>" href="<?= site_url('harga') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_atm</i>
                    </div>
                    <span class="nav-link-text ms-1">Harga <i>(PERDAGINKOP)</i></span>
                </a>
            </li>
        <?php endif ?>

        <?php if (!is_admin() && in_groups([3, 4])) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_harga_bahan ?>" href="<?= site_url('harga_bahan') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">price_check</i>
                    </div>
                    <span class="nav-link-text ms-1">Harga Bahan</span>
                </a>
            </li>
        <?php endif ?>

        <?php if (in_groups([1, 3, 4])) : ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_grafik ?>" href="<?= site_url('grafik') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assessment</i>
                    </div>
                    <span class="nav-link-text ms-1">Grafik Inflasi</span>
                </a>
            </li>
        <?php endif ?>

        <?php if (is_admin()) : ?>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">User Management</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_jabatan ?>" href="<?= site_url('jabatan') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">account_box</i>
                    </div>
                    <span class="nav-link-text ms-1">Jabatan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_pegawai ?>" href="<?= site_url('pegawai') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Pegawai</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_users ?>" href="<?= site_url('users') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">group</i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
        <?php endif ?>

    </ul>
</div>
<div class="sidenav-footer position-absolute w-100 bottom-0 ">
    <div class="mx-3">
        <a class="btn bg-gradient-primary w-100 btn-ask" href="<?= site_url('logout') ?>" data-title="Anda Yakin ?" data-message="Anda ingin mengakhiri sesi ini sekarang ?" type="button">Sign Out</a>
    </div>
</div>