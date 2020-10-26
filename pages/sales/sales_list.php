<?php
session_start();
include 'process.php';
$message = "";

?>
<?php
if (!isset($_SESSION['group'])) {
  header('location: ../utils/logout.php');
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


    <script type="text/javascript">
      function pickCost() {
        var customer = document.getElementById('customer').value;
        window.location.href = "sales_create.php?customer=" + customer;
      }
    </script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 mt-5">
              <div class="card card-primary">
              <section class="content">
        <div class="row">
          <div class="col-12">

            <div class="card card-primary">
              <div class="card-header" style="background-color: green;">
                <h3 class="card-title">Sales List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-11">&nbsp;</div>
                  <div class="col-md-1">
                    <a href="products_create.php" class="btn btn-primary" style="display:none;">Add</a>
                  </div>
                </div>
                <table id="table-here" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Transaction Date</th>
                      <th>Invoice No</th>
                      <th>Created By</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Sub Total</th>
                      <th>Amount Paid</th>
                      <th>Payment Type</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $number = 1;
                    $res = $conn->query("SELECT * FROM sales INNER JOIN users ON sales.salesman_id = users.id INNER JOIN products ON sales.product = products.id ORDER BY reference") or die($conn->error);
                    while ($row = $res->fetch_assoc()) :
                    ?>
                      <tr>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $row['tran_date']; ?></td>
                        <td><?php echo $row['reference']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['sub_total']; ?></td>
                        <td><?php echo $row['amount_paid']; ?></td>
                        <td><?php echo $row['payment_type']; ?></td>
                      </tr>
                    <?php $number++;
                    endwhile;  ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th style="width: 10px"></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>
                      </th>
                    </tr>
                  </tfoot>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
                  <hr>
                  <!-- /.card-body -->
              </div>

            </div>
          </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include __DIR__ . '/../partials/footer.php'; ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<?php include __DIR__ . '/../partials/scripts.php'; ?>
<!-- page script -->

<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript">
$(function() {

  $("#table-here").DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "dom": 'Bfrtip',
    "buttons": [
      'print', 'excel', 'pdf'
    ]
  });

});
</script>
<!-- Datatable Buttons -->

<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<!-- Datatables Buttons End -->


</body>

</html>