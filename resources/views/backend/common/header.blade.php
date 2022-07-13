<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo isset($titolo)?$titolo:'Arca Industry' ?></title>
        <link rel="icon" href="<?php echo URL::asset('img/ico.png') ?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/fontawesome-free/css/all.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/fullcalendar/main.css') ?>">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/jqvmap/jqvmap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/dist/css/adminlte.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/daterangepicker/daterangepicker.css') ?>">
        <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/summernote/summernote-bs4.min.css') ?>">
        <link rel="stylesheet" href="/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <script src="<?php echo URL::asset('backend/plugins/jquery/jquery.min.js') ?>"></script>
        <link rel="stylesheet" href="<?php echo URL::asset('backend/dist/css/print.min.css') ?>">

        <link href="<?php echo URL::asset('backend/plugins/keyboard/css/keyboard.css') ?>" rel="stylesheet">
        <link href="<?php echo URL::asset('backend/plugins/keyboard/css/keyboard-previewkeyset.css') ?>" rel="stylesheet">

        <!-- css for the preview keyset extension -->
       <style>
           .inline{
               max-width:400px;
               margin:auto;
           }
           .input-icons button {
               position: absolute;
               right: 1px;
           }

           .input-icons {
               width: 100%;
               margin-bottom: 10px;
           }

           .icon {
               padding: 10px;
               min-width: 40px;
           }

           .input-field {
               width: 100%;
               padding: 10px;
               text-align: center;
               margin-bottom: 3px;
           }
       </style>
    </head>




    <div style="position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;background: rgba(255, 255, 255,1);z-index: 1000000000;display: none;" id="ajax_loader">

        <img src="<?php echo URL::asset('img/logo.png') ?>" alt="AdminLTE Logo" style="width:400px;margin:0 auto;display:block;margin-top:200px;">
        <h2 style="text-align:center;margin-top:10px;">Operazione In Corso....</h2>
    </div>


    <body class="sidebar-mini layout-fixed sidebar-collapse">
    <!--<body class="hold-transition sidebar-mini layout-fixed">-->
        <div class="wrapper">
