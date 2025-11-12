<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>E - CI | Log in</title>
    
	<link rel="icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/icon/ecilogo.ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
    <!-- spesific page -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/login.css">

    <style>
        /* ===== BACKGROUND BARU ===== */
        body {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.75), rgba(0, 70, 150, 0.85)),
                url('<?= base_url() ?>assets/img/bg/bg.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Source Sans Pro', sans-serif;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <!-- <img src="<?= base_url() ?>assets/img/logo/ecilogo.png" alt="eci-logo" style="width:70px;"> -->
            <img src="<?= base_url() ?>assets/img/logo/sujlogo.png" alt="eci-logo" style="width:280px; margin-bottom:1.2rem;">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="<?= base_url() ?>assets/index3.html" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Enter Employee ID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-2">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- membuat checkbox tampilan password -->
                    <div class="icheck-primary d-block">
                        <input type="checkbox" id="customCheckbox1">
                        <label for="customCheckbox1" style="font-weight: normal !important;">Show Password</label>
                    </div>
                    <div class="row mt-3">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane mr-2"></i>Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->

                <p class="mb-1 mt-3 text-center">
                    <a href="forgot-password.html" class="text-muted">I forgot my password</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js?v=3.2.0"></script>
    <!-- spesific page -->
    <script src="<?= base_url() ?>assets/js/login.js"></script>
</body>


</html>