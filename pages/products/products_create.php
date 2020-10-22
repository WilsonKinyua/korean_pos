<?php
session_start();
include 'process.php';
if (!isset($_SESSION['group'])) {
  header('location: sections/utils/logout.php');
} else {
  $username = $_SESSION['userId'];
  $group = $_SESSION['group'];
}
?>
<!DOCTYPE html>
<html>
<?php
include __DIR__ . '/../partials/head.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    <!--    end sidebar-->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid mt-3">
          <div class="row">
          <div class="col-12">
          <div class="col-12">

              <?php if(isset($_COOKIE['product_success']) and $_COOKIE['product_success']) {?>
                  <div class="container-fluid">

                      <div class="row">
                          <div class="col-md-12 pt-4 text-center">                    
                          <div id="notif" class="alert alert-success text-center alert-dismissible fade show mt-4" role="alert">
                          <strong>Product Created Successfully</strong>
                          <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                          
                      </div>
                      </div>

                  </div>

              <?php } ?>

        <script>
            setTimeout(function() {
                let alerter = document.getElementById('notif')
                if(alerter) {
                alerter.parentNode.removeChild(alerter);
                }
            }, 30000)

        </script>
        </div>
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"> Add Product </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="products_create.php" method="POST">
                  <div class="card-body">
                    <div class="row">
                      <input type="hidden" name="id" value="">
                      <div class="col-md-4 form-group">
                        <label for="product_name">Product Name: <span style="color: red;">* <?php //echo $product_err; ?></span></label>
                        <input type="text" class="form-control" id="product_name" placeholder="Enter product name" name="product_name" value="" required>
                        <span style="color: red;"></span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>Category <span style="color: red;">*<?php //echo $category_err; ?></span></label>
                        <select name="category" class="form-control" name="category" required>
                          <?php
                          $category = $conn->query("SELECT * FROM product_categories ORDER BY name ASC") or die($conn->error);
                          ?>
                          <?php while ($row = $category->fetch_assoc()) : ?>
                            <option class="dropdown-item" value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>

                      <div class="col-md-4 form-group">
                        <label for="cost_price">Cost Price: <span style="color: red;">* <?php //echo $cost_err; ?></span></label>
                        <input type="number" class="form-control" id="cost_price" placeholder="Cost of item ($) eg 300" name="cost_price" value="" required>
                        <span style="color: red;"></span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label for="serial">Serial Number: </label>
                        <input type="text" class="form-control" id="serial" placeholder="Serial Numbe e.g. SKU: 1931029" name="serial" value="SKU: ">
                      </div>
                      <div class="col-md-4 form-group">
                        <label for="capacity">Capacity: <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="capacity" placeholder="Capacity(w) e.g. 650" name="capacity" value="" required>
                      </div>
                      <div class="col-md-4 form-group">
                        <label for="manu">Manufacturer: </label>
                        <input type="text" class="form-control" id="manu" placeholder="Manufacturer" name="manu" value="">
                      </div>

                      <div class="col-md-4 form-group">
                        <label for="distributor_cost">Technical Details: </label>
                        <textarea name="tech" id="tech" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary btn-lg" name="product_submit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->

    <?php
    include __DIR__ . '/../partials/footer.php';
    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <?php
  include_once '../partials/sidebar-js.php';
  ?>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../../dist/js/../dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
</body>

</html>