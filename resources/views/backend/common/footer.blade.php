

<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a target="_blank" href="https://softmaint.it">Softmaint SRL</a>.</strong>
    Tutti i Diritti Riservati
    <div class="float-right d-none d-sm-inline-block">
        <b>Versione</b> 4.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo URL::asset('backend/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>

<script src="<?php echo URL::asset('backend/plugins/fullcalendar/main.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/fullcalendar/locales-all.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?php echo URL::asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/sparklines/sparkline.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/datatables/jquery.dataTables.js') ?>"></script>
<script src="/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo URL::asset('backend/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/adminlte.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/demo.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/pages/dashboard.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/footer_script.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/countdown.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/print.min.js') ?>"></script>


<script src="<?php echo URL::asset('backend/plugins/keyboard/js/jquery.keyboard.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/keyboard/js/jquery.keyboard.extension-all.js') ?>"></script>

</body>
</html>


<script type="text/javascript">

    $('form').submit(function(){
        $('#ajax_loader').fadeIn();
    });


</script>
