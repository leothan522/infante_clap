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
    <link rel="apple-touch-icon" sizes="57x57" href="<?php asset('public\\favicon\\apple-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php asset('public\\favicon\\apple-icon-60x60.png') ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php asset('public\\favicon\\apple-icon-72x72.png') ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php asset('public\\favicon\\apple-icon-76x76.png') ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php asset('public\\favicon\\apple-icon-114x114.png') ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php asset('public\\favicon\\apple-icon-120x120.png') ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php asset('public\\favicon\\apple-icon-144x144.png') ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php asset('public\\favicon\\apple-icon-152x152.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php asset('public\\favicon\\apple-icon-180x180.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php asset('public\\favicon\\android-icon-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php asset('public\\favicon\\android-icon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php asset('public\\favicon\\android-icon-96x96.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php asset('public\\favicon\\favicon-16x16.png') ?>">
    <link rel="manifest" href="<?php asset('public\\favicon\\manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php asset('public\\favicon\\ms-icon-144x144.png') ?>">
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
    <?php require_once "_layout/navbar.php"; ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      <?php require '../admin/perfil/_layout/header.php'?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
          <?php require '../admin/perfil/_layout/content.php'; ?>
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

<!-- InputMask -->
<script src="<?php asset('app/resources/adminlte/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php asset('app/resources/adminlte/plugins/inputmask/jquery.inputmask.min.js'); ?>"></script>
<script src="<?php asset('public/js/inputmask-app.js', true); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php asset('app/resources/adminlte/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php asset('public/js/app.js', true); ?>"></script>
<script src="<?php asset('web/_app/app.js', true); ?>"></script>


</body>
</html>
