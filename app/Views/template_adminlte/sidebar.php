<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="/" target="_blank">
        <img src="<?= site_url('assets/dist/img/logo-bolmut.png') ?>" class="navbar-brand-img h-100 bg-white rounded p-1" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Jadwal Lab Komputer</span>
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

        <?php if (is_admin()) : ?>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Master</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_kelas ?>" href="<?= site_url('kelas') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">meeting_room</i>
                    </div>
                    <span class="nav-link-text ms-1">Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_mata_kuliah ?>" href="<?= site_url('mata_kuliah') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">library_books</i>
                    </div>
                    <span class="nav-link-text ms-1">Mata Kuliah</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_laboratorium ?>" href="<?= site_url('laboratorium') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">biotech</i>
                    </div>
                    <span class="nav-link-text ms-1">Laboratorium</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Data Dosen & Mahasiswa</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_dosen ?>" href="<?= site_url('dosen') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <span class="nav-link-text ms-1">Dosen</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_mahasiswa ?>" href="<?= site_url('mahasiswa') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <span class="nav-link-text ms-1">Mahasiswa</span>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Manajemen Jadwal</h6>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white <?= @$m_jadwal ?>" href="<?= site_url('jadwal') ?>">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">pending_actions</i>
                </div>
                <span class="nav-link-text ms-1">Jadwal</span>
            </a>
        </li>

        <?php if (is_admin()) : ?>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Laboratorium</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?= @$m_fasilitas ?>" href="<?= site_url('fasilitas') ?>">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">build_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">Fasilitas</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">User Management</h6>
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