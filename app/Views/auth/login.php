<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicons -->
  <link href="<?= site_url('assets/dist/img/logo-bolmut.png'); ?>" rel="icon" />
  <link href="<?= site_url('assets/dist/img/logo-bolmut.png'); ?>" rel="log-icon" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/validator.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/login.css') ?>" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <title>Login</title>
</head>

<body>
  <div class="wrapper">
    <div class="logo">
      <img src="<?= site_url('assets/dist/img/logo-bolmut2.png') ?>" alt="">
    </div>
    <div class="text-center mt-4 name">
      Lab Schedule
    </div>
    <?= isset($message) ? '<p class="login-box-msg error">' . $message . '</p>' : ''; ?>
    <?= form_open('log-in', array('id' => 'form-login', 'class' => 'p-3 mt-3')) ?>
    <input type="hidden" class="csrf-token" value="<?= csrf_token() ?>" />
    <input type="hidden" class="csrf-hash" value="<?= csrf_hash() ?>" />
    <div class="form-field d-flex align-items-center">
      <span class="far fa-user"></span>
      <input onkeyup="check()" id="email" type="text" autocomplete="off" placeholder="Username" name="identity" placeholder="<?= lang('Auth.login_identity_label') ?>" required>
    </div>
    <div class="form-field d-flex align-items-center">
      <span class="fas fa-lock" role="button" id="password-icon"></span>
      <input type="password" id="password" class="password" placeholder="Sandi" name="password" placeholder="<?= lang('Auth.login_password_label') ?>" required>
    </div>
    <button class="btn mt-3" type="submit" id="btn-login">Login</button>
    <button class="btn mt-3 d-none" type="button" disabled>
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading...
    </button>
    </form>
  </div>

  <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= base_url('assets/dist/js/validator.js') ?>"></script>
  <script src="<?= base_url('assets/dist/js/login.js') ?>"></script>
</body>

</html>