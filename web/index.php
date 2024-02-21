<?php
session_start();
require_once "../vendor/autoload.php";
use app\controller\WebController;
$controller = new WebController();
$controller->isAdmin();
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php asset('app/favicon/apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php asset('app\\favicon\\apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php asset('app\\favicon\\apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php asset('app\\favicon\\apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php asset('app\\favicon\\apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php asset('app\\favicon\\apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php asset('app\\favicon\\apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php asset('app\\favicon\\apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php asset('app\\favicon\\apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php asset('app\\favicon\\android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php asset('app\\favicon\\android-icon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php asset('app\\favicon\\android-icon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php asset('app\\favicon\\favicon-16x16.png') ?>">
    <link rel="manifest" href="<?php asset('app\\favicon\\manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php asset('app\\favicon\\ms-icon-144x144.png') ?>">
    <meta name="theme-color" content="#ffffff">
  <title><?php echo config('app_name'); ?> | Inicio</title>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php asset('app/resources/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php asset('app/resources/adminlte/dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="./" class="navbar-brand">
        <img src="<?php asset('public/img/logo_alguarisa_600x600.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo mb_strtoupper(config('app_name')) ?></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <button class="btn nav-link" onclick="irDashboard()">Dashboard</button>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item user-menu">
              <span class="nav-link">
                  <img src="<?php asset('app/resources/adminlte/dist/img/user2-160x160.jpg'); ?>" class="user-image img-circle elevation-2" alt="User Image">
                  <span class="d-none d-md-inline">
                    <?php echo $controller->USER_NAME; ?>
                </span>
              </span>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <!-- User image -->
                  <!--<li class="user-header bg-primary">
                      <img src="<?php /*asset('app/resources/adminlte/dist/img/user2-160x160.jpg'); */?>" class="img-circle elevation-2" alt="User Image">

                      <p>
                          <?php /*echo $controller->USER_NAME; */?>
                          <small><?php /*echo $controller->USER_EMAIL; */?></small>
                      </p>
                  </li>-->
                  <!-- Menu Footer-->
                  <!--<li class="user-footer">
                      <a href="../logout" class="btn btn-default btn-flat float-right">Cerrar sesión</a>
                  </li>-->
              </ul>
          </li>
        <li class="nav-item">
              <a class="nav-link" href="<?php asset('logout'); ?>" role="button">
                  <i class="fas fa-sign-out-alt"></i>
              </a>
          </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      <div class="row">
          header
      </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
            content
        </div>

      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php asset('app/resources/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php asset('app/resources/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php asset('app/resources/adminlte/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<script src="<?php asset('public/js/sweetalert-app.js', true);  ?>"></script>

<!-- AdminLTE App -->
<script src="<?php asset('app/resources/adminlte/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php asset('public/js/app.js', true); ?>"></script>
<script src="<?php asset('web/_app/app.js', true); ?>"></script>

</body>
</html>
