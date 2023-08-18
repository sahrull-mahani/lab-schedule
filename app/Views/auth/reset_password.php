<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicons -->
    <link href="<?= site_url('assetsbaru/img/favicon.png'); ?>" rel="icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link href="<?= site_url('assetsbaru/pendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('assetsbaru/css/resetsandi.css') ?>" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>Reset sandi</title>
</head>

<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Reset sandi</span>

                <?= form_open('auth/reset_password/' . $code, array("id" => "formregis")) ?>
                <div id="code" data-text="<?= $code ?>"></div>
                <!-- PASSWORD REGISTRASI -->
                <div class="input-field" id="passwordregis">
                    <input onkeyup="trigger()" id="createPw" name="new" type="password" class="password" placeholder="<?= sprintf(lang('Auth.reset_password_new_password_label'), $minPasswordLength) ?>" required />
                    <i class="uil uil-lock icon icon-lok2"></i>
                    <span class="showBtn">SHOW</span>
                </div>

                <div class="indicator">
                    <span class="weak"></span>
                    <span class="medium"></span>
                    <span class="strong"></span>
                </div>
                <div class="text-indicator"></div>
                <div class="input-field">
                    <input id="confirmPw" type="password" name="new_confirm" class="password" placeholder="<?= lang('Auth.reset_password_new_password_confirm_label'); ?>" required disabled />
                    <i class="uil uil-lock icon-lok"></i>
                    <i class="uil uil-eye-slash showHidePw icon-eye"></i>
                </div>
                <input type="hidden" name="user_id" value="<?= $user_id; ?>" id="user_id" />
                <div class="input-field button-regis">
                    <input type="submit" value="Reset" />
                </div>
                <div class="d-grid mt-3 d-none">
                    <button class="btn btn-primary btn-lg" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= site_url('assetsbaru/pendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url('assets/dist/js/validator.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="<?= base_url('assetsbaru/js/resetsandi.js') ?>"></script>
</body>

</html>