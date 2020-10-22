<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<?php
include_once 'sidebar-js.php';
?>
<script>
    $(".alert:not(.dont-close)").fadeTo(8000, 500).slideUp(500, function(){
        $(".alert:not(.dont-close)").slideUp(500);
    });
</script>