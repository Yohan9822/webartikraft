<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Web Artikraft</title>
    <link rel="stylesheet" href="<?= getURL('public/cms/css/template.css') ?>">
    <link rel="stylesheet" href="<?= getURL('public/cms/css/login.css') ?>">
    <link rel="stylesheet" href="<?= getURL('public/cms/css/boxicons.css') ?>">
    <link rel="stylesheet" href="<?= getURL('public/cms/css/notyf.css') ?>">
</head>

<body>
    <div class="content">
        <div class="container-fluid sc-sm p-x">
            <div class="container-fluid sc-sm p-x">
                <div class="login-logo">
                </div>
                <div class="content-log">
                    <div class="head-log">
                        <h4>Login Now</h4>
                        <p>Log In to Continue Our App</p>
                    </div>
                    <div class="form-log">
                        <form class="no-padding" id="form-login-sm" method="POST">
                            <div style="width: 300px;margin-top: 20px;font-size: 12px" data-toggle="label-message"></div>
                            <div class="form-group">
                                <label>Username</label>
                                <div class="form-append">
                                    <i class="bx bx-at text-dark form-append-leading"></i>
                                    <input type="text" name="username-sm" id="username-sm" class="form-input uname" placeholder="ex: usernum811" autofocus>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 25px; margin-bottom: 70px">
                                <label>Password</label>
                                <div class="form-append">
                                    <i class="bx bx-lock text-dark form-append-leading"></i>
                                    <input type="password" name="password-sm" id="password-sm" class="form-input" placeholder="••••••••••••••">
                                    <i class="bx bx-hide text-dark form-append-trailing" show="n" id="show-pass"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary d-flex align-center justify-center" id="btn-login-sm">
                                    <i class="bx bx-door-open margin-r-2"></i>
                                    <span class="fw-normal fs-7">Login</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid sc-lg p-x login-bg">
            <div class="login-card">
                <div class="dflex align-center justify-center flex-column">
                    <label class="login-label">Login</label>
                    <p class="fs-7">Log In to Access Web Artikraft CMS</p>
                </div>
                <div style="width: 300px;margin-top: 20px;font-size: 12px" data-toggle="label-message"></div>
                <form id="form-login" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <div class="form-append">
                            <i class="bx bx-at text-dark"></i>
                            <input type="text" name="username" id="username" class="form-input" style="padding-left: 0px;" placeholder="@ex: usernum811" autofocus>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 25px; margin-bottom: 70px">
                        <label>Password</label>
                        <div class="form-append">
                            <i class="bx bx-lock text-dark"></i>
                            <input type="password" name="password" id="password" class="form-input" style="padding-left: 0px;" placeholder="••••••••••••••">
                            <i class="bx bx-hide text-dark show-pass" show="n"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary d-flex align-center justify-center" id="btn-login">
                            <i class="bx bx-door-open margin-r-2"></i>
                            <span class="fw-normal fs-7">Login</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- <div class="dflex align-center justify-center margin-t-3">
                <span class="fw-semibold fs-7 text-primary">Copyright © 2024 PT Hyperdata Solusindo Mandiri</span>
            </div> -->
        </div>
    </div>
    <input type="hidden" id="csrf_token" value="<?= base_encode(csrf_hash()) ?>">
</body>

</html>
<script src="<?= getURL('public/cms/js/jquery.js') ?>"></script>
<script src="<?= getURL('public/cms/js/bootstrap.js') ?>"></script>
<script src="<?= getURL('public/cms/js/editor.js') ?>"></script>
<script src="<?= getURL('public/cms/js/notyf.js') ?>"></script>
<script src="<?= getURL('public/cms/js/script.js') ?>"></script>
<script src="<?= getURL('public/cms/js/app.js') ?>"></script>
<script>
    function showPass(item, val) {
        $(item).removeClass();
        let vale = '',
            icn = '';
        if (val == 'y') {
            vale = 'n';
            icn = 'bx bx-hide';
            $(item).siblings('#password').attr('type', 'password');
            $(item).siblings('#pword').attr('type', 'password');
        } else {
            vale = 'y';
            icn = 'bx bx-show';
            $(item).siblings('#password').attr('type', 'text');
            $(item).siblings('#pword').attr('type', 'text');
        }
        $(item).attr('show', vale);
        $(item).addClass(`${icn} text-dark`);
    }

    function login(link, data) {
        data['<?= csrf_token() ?>'] = decrypter($("#csrf_token").val());
        $.ajax({
            url: link,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(res) {
                $("#csrf_token").val(encrypter(res.csrfToken))

                if (res.sukses == 1) {
                    showSuccess(res.pesan)
                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 100);
                } else {
                    showError(res.pesan)
                    $('#form-login')[0].reset();
                    $('#form-login-sm')[0].reset();
                    $('#username').focus();
                    $('#username-sm').focus();
                }

                $('#btn-login').removeAttr('disabled');
                $('#btn-login-sm').removeAttr('disabled');
                $('#btn-login').html(`
                        <i class="bx bx-door-open margin-r-2"></i>
                        <span class="fw-normal fs-7">Login</span>
                    `)
                $('#btn-login-sm').html(`
                        <i class="bx bx-door-open margin-r-2"></i>
                        <span class="fw-normal fs-7">Login</span>
                    `)
            },
            error: function(xhr, ajaOptions, thrownError) {
                if (xhr.responseJSON !== undefined) {
                    if (xhr.responseJSON.pesan !== undefined) showError(xhr.responseJSON.pesan);
                    else showError('Invalid response from server');


                    if (xhr.responseJSON.redirect !== undefined) {
                        setTimeout(() => window.location.href = xhr.responseJSON.redirect, 1000);
                    }
                } else showError('Invalid response from server');

                $('#btn-login').removeAttr('disabled');
                $('#btn-login-sm').removeAttr('disabled');
                $('#btn-login').html(`
                        <i class="bx bx-door-open margin-r-2"></i>
                        <span class="fw-normal fs-7">Login</span>
                    `)
                $('#btn-login-sm').html(`
                        <i class="bx bx-door-open margin-r-2"></i>
                        <span class="fw-normal fs-7">Login</span>
                    `)
            }
        })
    }
    $(document).ready(async function() {
        $('#form-login, #form-login-sm').find('input, button').attr('disabled', 'disabled');
        $('#form-login, #form-login-sm').on((e) => e.preventDefault());

        $('#form-login').submit(function(e) {
            e.preventDefault();
            var spin = `<i class="bx bx-loader-alt bx-spin">`;

            $('#btn-login').html(spin);
            $('#btn-login').attr('disabled', true);
            $('#btn-log-in').html(spin);
            $('#btn-log-in').attr('disabled', true);
            var link = '<?= getURL('cms/auth/login') ?>',
                username = $('#username').val(),
                password = $('#password').val();

            login(link, {
                username: username,
                password: password,
                lat: -1,
                long: -1,
            });
        });

        $('#form-login-sm').submit(function(evt) {
            evt.preventDefault();
            var spin = `<i class="bx bx-loader-alt bx-spin">`;

            $('#btn-login-sm').html(spin);
            $('#btn-login-sm').attr('disabled', true);
            var link = '<?= getURL('cms/auth/login') ?>',
                username = $('#username-sm').val(),
                password = $('#password-sm').val();

            login(link, {
                username: username,
                password: password,
                lat: -1,
                long: -1,
            });
        })

        $('#form-login, #form-login-sm').find('input, button').removeAttr('disabled');

        $('.show-pass').click(function(e) {
            var vlue = $(this).attr('show');
            showPass(e.target, vlue);
        })
    })
</script>