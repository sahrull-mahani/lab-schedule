<?= $this->extend('template_adminlte/index') ?>
<?= $this->section('page-content') ?>

<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <?= form_open_multipart('auth/change_pic', array('id' => 'change-pic')) ?>
                    <input type="file" name="profile" class="files d-none" accept="image/*">
                    <img class="w-100 border-radius-lg shadow-sm profile-pictures" id="profile-pic" role="button" src="<?= session('full') ?>" alt="User profile picture">
                    <div class="btn-group d-none mt-2" role="group" aria-label="Basic outlined example">
                        <button class="btn btn-sm btn-primary" type="submit" id="upload"><i class="bi bi-upload"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" id="cancel" data-picture="<?= session('full') ?>"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        Richard Davis
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        CEO / Co-Founder
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#home-tab-pane" role="tab" aria-selected="true">
                                <i class="material-icons text-lg position-relative">manage_accounts</i>
                                <span class="ms-1">Manage Account</span>
                            </a>
                        </li>
                        <?php if (!is_admin()) : ?>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#profile-tab-pane" role="tab" aria-selected="false">
                                    <i class="material-icons text-lg position-relative">person</i>
                                    <span class="ms-1">Profile</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tab-content" id="myTabContent">
                <!-- Management Account -->
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <?= form_open('auth/change_password', array('class' => 'form-horizontal', 'id' => 'save-account')); ?>
                    <label for="nama_user">Nama</label>
                    <div class="input-group input-group-outline mb-3">
                        <input type="text" name="nama_user" value="<?= isset($get->nama) ? $get->nama : $user->nama_user; ?>" id="nama_user" class="form-control" required="required" <?= isset($get->nama) ? 'readonly' : ''; ?> />
                    </div>
                    <?= form_label(lang('Auth.edit_username_label'), 'username', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="input-group input-group-outline mb-3">
                        <input type="text" name="username" value="<?= isset($user->username) ? $user->username : ''; ?>" id="username" class="form-control" required="required" <?= $identityColumn === 'username' ? 'readonly' : ''; ?> />
                    </div>
                    <?= form_label(lang('Auth.edit_user_email_label'), 'email', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="input-group input-group-outline mb-3">
                        <input type="text" name="email" value="<?= isset($user->email) ? $user->email : ''; ?>" id="email" class="form-control" required="required" <?= $identityColumn === 'email' ? 'readonly' : ''; ?> />
                    </div>
                    <?= form_label(lang('Auth.edit_user_email_label'), 'email', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="input-group input-group-outline mb-3">
                        <input type="text" name="phone" value="<?= isset($user->phone) ? $user->phone : ''; ?>" id="phone" class="form-control" required="required" />
                    </div>
                    <label for="old_password"><?= lang('Auth.change_password_old_password_label'); ?></label>
                    <div class="input-group input-group-outline mb-3">
                        <?= form_input($old_password); ?>
                    </div>
                    <label for="new_password"><?= sprintf(lang('Auth.change_password_new_password_label'), $minPasswordLength); ?></label>
                    <div class="input-group input-group-outline mb-3">
                        <?= form_input($new_password); ?>
                    </div>
                    <label for="new_password_confirm"><?= lang('Auth.change_password_new_password_confirm_label'); ?></label>
                    <div class="input-group input-group-outline mb-3">
                        <?= form_input($new_password_confirm); ?>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <?= form_hidden('id', session('user_id')); ?>
                        <?= form_submit('submit', lang('Auth.change_password_submit_btn'), ['class' => 'btn btn-primary']); ?>
                    </div>
                    <?= form_close() ?>
                </div>
                <!-- END Management Account -->

                <?php if (!is_admin()) : ?>
                    <!-- Profile -->
                    <div class="tab-pane fade show" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <?= form_open("pegawai/save", array("class" => "form-horizontal", "id" => "save-profile")) ?>
                        <label for="nama">Nama</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control" id="nama" name="nama[]" value="<?= (isset($get->nama)) ? $get->nama : $get->nama_user; ?>" placeholder="Nama" required />
                        </div>
                        <label for="jab_id">Jabatan</label>
                        <div class="input-group input-group-outline mb-3">
                            <?php $defaults = array('' => 'Pilih Jabatan');
                            echo form_dropdown('jab_id[]', $defaults + jabatan(), (isset($get->jab_id)) ? $get->jab_id : '', 'class="form-control" id="jab_id" required'); ?>
                        </div>
                        <label for="jk">Jenis Kelamin</label>
                        <div class="input-group input-group-outline mb-3">
                            <?php $defaults = array('' => '==Pilih Jk==');
                            $options = array(
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            );
                            echo form_dropdown('jk[]', $defaults + $options, (isset($get->jk)) ? $get->jk : '', 'class="form-control" id="jk" ');
                            ?>
                        </div>
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir[]" value="<?= (isset($get->tempat_lahir)) ? $get->tempat_lahir : ''; ?>" placeholder="Tempat Lahir" />
                        </div>
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir[]" value="<?= (isset($get->tgl_lahir)) ? get_format_date($get->tgl_lahir) : ''; ?>" placeholder="Tgl Lahir" />
                        </div>
                        <label for="gelar_depan">Gelar Depan</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control" id="gelar_depan" name="gelar_depan[]" value="<?= (isset($get->gelar_depan)) ? $get->gelar_depan : ''; ?>" placeholder="Gelar Depan" />
                        </div>
                        <label for="gelar_belakang">Gelar Belakang</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang[]" value="<?= (isset($get->gelar_belakang)) ? $get->gelar_belakang : ''; ?>" placeholder="Gelar Belakang" />
                        </div>
                        <label for="alamat">Alamat</label>
                        <div class="input-group input-group-outline mb-3">
                            <textarea class="form-control" id="alamat" name="alamat[]" placeholder="Alamat"><?= (isset($get->alamat)) ? $get->alamat : ''; ?></textarea>
                        </div>
                        <label for="alamat">Pendidikan</label>
                        <div class="input-group input-group-outline mb-3">
                            <?php $defaults = array('' => '==Pilih Pendidikan==');
                            $options = array(
                                'S3' => 'S3',
                                'S2' => 'S2',
                                'S1/D4' => 'S1/D4',
                                'D3' => 'D3',
                                'D2' => 'D2',
                                'D1' => 'D1',
                                'SMA/SMK/MA' => 'SMA/SMK/MA',
                            );
                            echo form_dropdown('pendidikan[]', $defaults + $options, (isset($get->pendidikan)) ? $get->pendidikan : '', 'class="form-control" id="pendidikan" ');
                            ?>
                        </div>
                        <label for="lulusan">Lulusan</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="text" class="form-control" id="lulusan" name="lulusan[]" value="<?= (isset($get->lulusan)) ? $get->lulusan : ''; ?>" placeholder="Lulusan" />
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />
                            <input type='hidden' name='action' value='update' />
                            <input type='hidden' name='session' value='true' />
                            <?= form_submit('submit', lang('Auth.edit_user_submit_btn'), ['class' => 'btn btn-primary']); ?>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <!-- END Profile -->
                <?php endif ?>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>