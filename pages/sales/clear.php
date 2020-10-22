<?php 
  session_start();
    include 'process.php';

    if (!isset($_SESSION['group'])) {
      header('location: ../utils/logout.php');
    }else{
      $username = $_SESSION['username'];
      $group = $_SESSION['group'];
      $userId = $_SESSION['userId'];
    }

    if (isset($_GET['clear'])) {

      $id = $_GET['clear'];

      if ($id) {

        $res = $conn->query("SELECT product, quantity_available, sold FROM stock_mobile WHERE clear_status='0' AND store_owner='$id'") or die($conn->error);

        while ($row = $res->fetch_assoc()) {

          // var_dump($row);
          $product = $row['product'];
          // echo "\nProduct: ".$product;
          $quantity = $row['quantity_available']-$row['sold'];
          // echo "\nQuantity: ".$quantity;
          $stock = $conn->query("SELECT * FROM stock WHERE product='$product'") or die($conn->error);
          $result = $stock->fetch_array();
          // var_dump($result);
          echo mysqli_num_rows($stock);
          // echo "\nQuantity: ".$quantity;
          $quantity += $result['quantity_available'];
          // echo "Quantity2: ".$quantity;
          $exec = $conn->query("UPDATE stock SET quantity_available='$quantity' WHERE product='$product'") or die($conn->error);

          if ($exec) {

              $conn->query("UPDATE stock_mobile SET clear_status='1', approved_by = '$userId' WHERE store_owner='$id' AND product='$product'") or die("Connection error");

          }

        }
        $_SESSION['success'] = 'Stock cleared successfully';
        header('clear.php');
        exit();
      }
        header('clear.php');
        exit();
    }

if (isset($_GET['clear_print'])) {

    $id = $_GET['clear_print'];

    if ($id) {

        $approved = [];

        $res = $conn->query("SELECT id,product, quantity_available, sold FROM stock_mobile WHERE clear_status='0' AND store_owner='$id'") or die($conn->error);

        while ($row = $res->fetch_assoc()) {
            array_push($approved, $row['id']);

            // var_dump($row);
            $product = $row['product'];
            // echo "\nProduct: ".$product;
            $quantity = $row['quantity_available']-$row['sold'];
            // echo "\nQuantity: ".$quantity;
            $stock = $conn->query("SELECT * FROM stock WHERE product='$product'") or die($conn->error);
            $result = $stock->fetch_array();
            // var_dump($result);
            echo mysqli_num_rows($stock);
            // echo "\nQuantity: ".$quantity;
            $quantity += $result['quantity_available'];
            // echo "Quantity2: ".$quantity;
            $exec = $conn->query("UPDATE stock SET quantity_available='$quantity' WHERE product='$product'") or die($conn->error);

            if ($exec) {

                $conn->query("UPDATE stock_mobile SET clear_status='1', approved_by = '$userId' WHERE store_owner='$id' AND product='$product'") or die("Connection error");

            }

        }
        $_SESSION['success'] = 'Stock cleared successfully';
        $_SESSION['dont_close_alert'] = $id;
        $_SESSION['approved'] = [
            $id => $approved
        ];
        header('Location: clear.php');
        exit();
    }
    header('Location: clear.php');
    exit();
}

if (isset($_GET['clear_approved'])){
    unset($_SESSION['approved']);
}

 ?>


<!DOCTYPE  html>
<html>

  <?php include __DIR__.'/../partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include __DIR__.'/../partials/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include __DIR__.'/../partials/sidebar.php'; ?>
    <!--    end sidebar-->

  <script type="text/javascript">

    function evalResults() {

      var salesman=document.getElementById('salesman').value;
      window.location.href = "clear.php?salesman="+salesman;

    }

  </script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php
                if (isset($_SESSION['error'])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show <?= isset($_SESSION['dont_close_alert'])? 'dont-close':'' ?>" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['error']); }
                if (isset($_SESSION['success'])){ ?>
                    <div class="alert alert-success alert-dismissible fade show <?= isset($_SESSION['dont_close_alert'])? 'dont-close':'' ?>" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['success']); }
                ?>
            </div>
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Reconcile Sales</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="location_id">Salesman:</label>
                      <select class="form-control" name="salesman" id="salesman" onchange="evalResults()">
                        <option value="">Main Store</option>
                        <?php

                            $salesmen_group = 7;

                            $stores = $conn->query("SELECT id, name FROM users WHERE user_group='$salesmen_group'") or die($conn->error);

                            while ($row=$stores->fetch_assoc()) {

                              if (isset($_GET['salesman'])) {

                                if ($row['id'] == $_GET['salesman']) {

                                  echo "<option value=".$row['id']." selected>".$row['name']."</option>";

                                } else {

                                  echo "<option value=".$row['id'].">".$row['name']."</option>";

                                }

                              } else {

                                echo "<option value=".$row['id'].">".$row['name']."</option>";

                              }

                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Quantity Issued</th>
                      <th>Quantity Sold</th>
                      <th>Returned</th>
                      <th>Sales</th>

                  </tr>
                  </thead>
                  <tbody>

                    <?php

                        $sql = "SELECT * FROM stock INNER JOIN products ON stock.product=products.id";

                        if (isset($_GET['salesman'])) {

                          $sid = $_GET['salesman'];

                          if (empty($sid)) {

                            $sql = "SELECT * FROM stock INNER JOIN products ON stock.product=products.id";

                          } else {

                            $sql = "SELECT * FROM stock_mobile INNER JOIN products ON stock_mobile.product=products.id WHERE clear_status=0 AND store_owner='$sid'";

                          }

                        }

                        $count = 0;
                        $res = $conn->query($sql) or die($conn->error);

                        while ($row = $res->fetch_assoc()) {

                          $count += 1;

                          echo "<tr>";

                          echo "<td>".$row['name']."</td>";

                          echo "<td>".$row['quantity_available']."</td>";

                          $sid = isset($_GET['salesman']) ? $_GET['salesman'] : "";

                          if ($sid != "") {
                            echo "<td>".$row['sold']."</td>";

                            echo "<td>".($row['quantity_available'] - $row['sold'])."</td>";

                            $date = date('Y-m-d');

                            echo "<td>".$row['sold']*$row['stockist']."</td>";

                          } else {

                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";

                          }


                      echo "</tr>";

                    }?>

                    <?php if (!empty(($_GET['salesman'])) && ($count > 0)): ?>

                      <td colspan="4">&nbsp;</td>

                      <td colspan="2">
                        <a href="clear.php?clear=<?php echo $_GET['salesman']; ?>" class="btn btn-success">Approve</a>
                        <a href="clear.php?clear_print=<?php echo $_GET['salesman']; ?>" class="btn btn-success">Approve and Print</a>
                        <a href="declare_short.php?clear=<?php echo $_GET['salesman']; ?>" class="btn btn-danger">Declare Short</a>
                      </td>

                    <?php endif; ?>

                  </tbody>

                  <!--<tfoot>-->
                  <!--<tr>-->
                  <!--  <th>Product Name</th>-->
                  <!--  <th>Quantity Issued</th>-->
                  <!--  <th>Quantity Sold</th>-->
                  <!--  <th>Returned</th>-->
                  <!--  <th>Sales</th>-->
                  <!--</tr>-->
                  <!--</tfoot>-->
                </table>
                  <?php
                  if (isset($_SESSION['dont_close_alert'])){ ?>
                      <button hidden id="print" onclick="window.open('cleared_print.php?id=<?= $_SESSION['dont_close_alert'] ?>', '_blank');"></button>
                  <?php }
                  ?>
                 <div class="col-sm-12">
            <!-- <button type="button" class="btn btn-primary pull-right" aria-label="Print" onclick="window.print()"><i class="fa fa-print"></i> Print</button> -->
            </div>
              </div>
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
<?php
include __DIR__.'/../partials/footer.php';
?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

<?php
include __DIR__.'/../partials/scripts.php';
?>

<!-- Datatable Buttons -->

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<!-- Datatables Buttons End -->

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Page specific script -->

<script type="text/javascript">
    <?php
    if (isset($_SESSION['dont_close_alert'])){ ?>
    $('button#print').trigger('click');
    <?php unset($_SESSION['dont_close_alert']); }
    ?>
$(function () {
  $("#example1").DataTable({
    "dom": 'Bfrtip',
    "buttons": [
        'print', 'excel', 'pdf'
    ]
  });


});
</script>
  </body>
  </html>
