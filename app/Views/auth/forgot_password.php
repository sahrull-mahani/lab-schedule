<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicons -->
    <link href="<?= site_url('assetsbaru/img/favicon.png'); ?>" rel="icon" />
    <link href="<?= site_url('assetsbaru/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon" />
    <link href="<?= site_url('assetsbaru/pendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('assetsbaru/css/lupasandi.css') ?>" />
    <title>Lupa sandi | Diskominfo</title>
</head>

<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Lupa sandi</span>

                <!-- FORM MASUK -->
                <?= form_open('auth/forgot_password') ?>
                <div class="input-field">
                    <input onkeyup="check()" id="email" type="<?php echo (($type === 'email') ? 'email' : 'text'); ?>" autocomplete="off" name="identity" placeholder="<?php echo (($type === 'email') ? sprintf(lang('Auth.forgot_password_email_label'), $identity_label) : sprintf(lang('Auth.forgot_password_identity_label'), $identity_label)); ?>" required />
                    <i class="uil uil-envelope icon"></i>
                </div>

                <div class="input-field button">
                    <input type="submit" value="Kirim" />
                </div>
                <div class="d-grid mt-4 d-none">
                    <button class="btn btn-primary btn-lg" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
                </form>
                <div class="login-signup">
                    <span class="text">
                        <a href="<?= site_url('login'); ?>" class="text">Masuk ke akun</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= site_url('assetsbaru/pendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= site_url('assetsbaru/js/swiper-bundle.min.js'); ?>"></script>

    <script src="<?= base_url('assetsbaru/js/lupasandi.js') ?>"></script>
</body>

</html>