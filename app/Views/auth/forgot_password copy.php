<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?> | Satpol PP</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/validator.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/forgot.css') ?>" />
</head>

<body class="hold-transition login-page" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.7), rgba(0, 255, 100, 0.3)), url('<?= base_url('assets/dist/img/bg-login-polpp.jpg') ?>'); backdrop-filter: grayscale(60%) blur(2px) brightness(70%) contrast(60%);">
    <d iv class="login-box">
        <div class="card card-outline card-primary" style="background-image: url('<?= base_url('assets/dist/img/pattern2.jpg') ?>'); background-repeat: no-repeat; background-size: cover;">
            <div class="card-header text-center bg-white-60">
                <a href="<?= site_url('admin/auth/forgot_password') ?>"><?= lang('Auth.forgot_password_heading'); ?></a>
            </div>

            <div class="card-body">
                <p class="login-box-msg"><?= sprintf(lang('Auth.forgot_password_subheading'), $identity_label); ?>
                    <br> <?= $message; ?>
                </p>
                <?= form_open('forgot_password'); ?>
                <div class="input-group mb-3">
                    <input type="<?= (($type === 'email') ? 'email' : 'text'); ?>" name="identity" id="identity" class="form-control" placeholder="<?= (($type === 'email') ? sprintf(lang('Auth.forgot_password_email_label'), $identity_label) : sprintf(lang('Auth.forgot_password_identity_label'), $identity_label)); ?>" required />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                    </div>
                    <!-- /.col -->
                </div>

                </form>
                <p class="mt-3 mb-1">
                    <a href="<?= site_url('login'); ?>">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
        </div>
        <!-- /.login-box -->

        <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
        <script src="<?= base_url('assets/dist/js/validator.js') ?>"></script>
        <script>
            title = $('title').html() + ' ';
            position = 0;

            function scrolltitle() {
                document.title = title.substring(position, title.length) + title.substring(0, position);
                position++;
                if (position > title.length) position = 0;
                titleScroll = window.setTimeout(scrolltitle, 170);
            }
            scrolltitle();

            $('input').on('focus', function() {
                $('body').css('backdrop-filter', 'grayscale(60%) blur(10px) brightness(70%) contrast(60%)')
                $('body').css('transition', 'all ease-in .3s')
            })
            $('input').on('focusout', function() {
                $('body').css('backdrop-filter', 'grayscale(60%) blur(2px) brightness(70%) contrast(60%)')
                $('body').css('transition', 'all ease-in .3s')
            })

            $('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change', 'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress);
            $('.multi.required').on('keyup blur', 'input', function() {
                validator.checkField.apply($(this).siblings().last()[0]);
            });
            $('form').submit(function(e) {
                e.preventDefault();
                if (!validator.checkAll($(this))) {
                    false;
                } else {
                    $.ajax({
                        url: $(this).attr("action"),
                        type: 'post',
                        data: $("form").serialize(),
                        beforeSend: function() {
                            let timerInterval
                            Swal.fire({
                                position: 'top',
                                title: 'Request Reset Password',
                                html: 'Mohon Tunggu Sebentar in <b></b> milliseconds.',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            })
                        },
                        success: function(response) {
                            var data = $.parseJSON(response);
                            swal.fire({
                                position: 'top',
                                icon: data.type,
                                title: data.title,
                                html: data.text
                            }).then((result) => {
                                if (data.type == 'success') {
                                    window.location.replace('<?= site_url('login') ?>');
                                }
                            });
                        },
                        error: function(jqXHR, exception, thrownError) {
                            swal.fire({
                                title: "Error code" + jqXHR.status,
                                html: thrownError + ", " + exception,
                                icon: "error"
                            }).then((result) => {
                                $("#spinner").hide();
                            });
                        }
                    });
                }
            });
        </script>
</body>

</html>