<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>E - CI | Reset Password</title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/icon/ecilogo.ico">

    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css">
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
    <?php $this->load->view('components/alert'); ?>
    <div class="login-box">
        <div class="login-logo">
            <!-- <img src="<?= base_url() ?>assets/img/logo/ecilogo.png" alt="eci-logo" style="width:70px;"> -->
            <img src="<?= base_url() ?>assets/img/logo/sujlogo.png" alt="eci-logo" style="width:280px; margin-bottom:1.2rem;">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Reset your password</p>

                <?= form_open('reset-password/process'); ?>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="New Password" required>
                </div>
                
                <div class="input-group mb-3">
                    <input type="password" name="password_confirm" class="form-control" placeholder="Confirm New Password" required>
                </div>

                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-paper-plane mr-2"></i>Reset Password</button>
                <?= form_close(); ?>

            </div>
        </div>
    </div>

    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js?v=3.2.0"></script>
    <!-- Toastr -->
    <script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
    <!-- spesific page -->
    <script src="<?= base_url() ?>assets/js/login.js"></script>
    <script src="<?= base_url() ?>assets/js/custome-toast.js"></script>
</body>


</html>