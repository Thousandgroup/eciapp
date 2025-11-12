<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-CI | TITLE</title>

	<link rel="icon" type="image/x-icon" href="<?= base_url('assets/'); ?>img/icon/ecilogo.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?php $this->load->view('partials/styles'); ?>
</head>

<body class="hold-transition layout-fixed accent-primary">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php $this->load->view('components/navbar'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view('components/sidebar'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="position: relative;">

            <!-- Overlay Loading -->
            <div id="content-loading-overlay">
                <div class="text-center d-flex align-items-center flex-column">
                    <div class="loader-spinner"></div>
                    <div id="content-loading-text" class="loading-text mt-2">Loading ...</div>
                </div>
            </div>

            <!-- Content Header (Page header) -->
            <?php $this->load->view('components/header'); ?>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <?= $contents ?>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('components/footer'); ?>

    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('partials/scripts'); ?>
</body>

</html>