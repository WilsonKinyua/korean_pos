<?php
session_start();
if (!isset($_SESSION['group'])) {

  header('location: sections/utils/logout.php');

} else {
  $username = $_SESSION['username'];
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
        <div class="row">
          <div class="col-12">

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Products Reorder Level</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12">
                    
                  <form method="POST"  class="form pt-3 pb-3">
                      <select onchange="storeDataLoader()" class="form-control" id="store" name="store">

                            <?php 

                                if(!isset($_GET['store']) or $_GET['store'] == "") {

                                  echo "<option value=''> All Stores </option>";

                                } else {

                                  $store = $_GET['store'];
                                  $store_data = $conn->query("SELECT name, id FROM stores where id='$store'") or die($conn->error); 
                                  $column = $store_data->fetch_array();
                                  echo "<option selected value=".$_GET['store'].">".$column['name']."</option>";
                                  echo "<option value=''> All Stores </option>";

                                }
                              ?> 
                        
                              <?php

                                $stores = $conn->query("SELECT id, name FROM stores order by name") or die($conn->error);

                                while ($row=$stores->fetch_assoc()) {

                                  echo "<option value=".$row['id'].">".$row['name']."</option>";
                                  
                                }

                              ?>
                        </select>
                  </form>

                  </div>
                </div>

                <table id="table-here" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Category</th>
                      <th>Price </th>
                      <th>Min Quantity</th>
                      <th>Quantity Available</th>
                      <th>Store Name</th>
                      <th>Alert</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      if(!isset($_GET['store']) or $_GET['store'] == "") {

                          $res = $conn->query(
                            "SELECT 
                                products.id as product_id,
                                products.name as product_name,
                                IFNULL(products.min_quantity, 0) as min_quantity,
                                products.category,
                                IFNULL(products.price, 0) as price,
                                IFNULL(products.selling_cost, 0) as selling_cost,
                                IFNULL(products.wholesale, 0) as wholesale,
                                IFNULL(products.stockist, 0) as stockist,
                                IFNULL(products.distributor, 0) as distributor,
                                IFNULL(products.retail, 0) as retail,
                                IFNULL(products.other, 0) other,
                                IFNULL(products.store, 0) as store,
                                IFNULL(tax_rates.tax_rate, 0) as tax_rate,
                                stores.name as store_name,
                                IFNULL(stock.quantity_available, 0) as quantity_available
                            FROM products
                            LEFT JOIN stock ON stock.product=products.id
                            LEFT JOIN stores ON stores.code=products.vendor
                            LEFT JOIN tax_rates ON products.tax_id=tax_rates.id
                            WHERE IFNULL(stock.quantity_available, 0) <= IFNULL(products.min_quantity, 0)
                            ORDER BY products.name ASC"
                          ) or die($conn->error);

                          while ($row = $res->fetch_assoc()) :
                          ?>
                            <tr>
                              <td><?php echo $row['product_name']; ?></td>
                              <td><?php echo $row['category']; ?></td>
                              <td><?php echo $row['price']; ?></td>
                              <td><?php echo $row['min_quantity']; ?></td>
                              <td><?php echo $row['quantity_available']; ?></td>
                              <td><?php echo $row['store_name']; ?></td>
                              <td>
                                <?php
                                  if($row['quantity_available'] <= $row['min_quantity']) {
                                    echo "<span style='color: red;'> Low </span>";
                                  } else {
                                    echo "<span style='color: green;'> Level Ok </span>";
                                  }
                                ?>
                              </td>
    
                            </tr>
                          <?php
                            
                            endwhile; } else if(isset($_GET['store']) and !empty($_GET['store'])) {

                              $store = $_GET['store'];

                              $res = $conn->query(
                                "SELECT 
                                    products.id as product_id,
                                    products.name as product_name,
                                    IFNULL(products.min_quantity, 0) as min_quantity,
                                    products.category,
                                    IFNULL(products.price, 0) as price,
                                    IFNULL(products.selling_cost, 0) as selling_cost,
                                    IFNULL(products.wholesale, 0) as wholesale,
                                    IFNULL(products.stockist, 0) as stockist,
                                    IFNULL(products.distributor, 0) as distributor,
                                    IFNULL(products.retail, 0) as retail,
                                    IFNULL(products.other, 0) other,
                                    IFNULL(products.store, 0) as store,
                                    IFNULL(tax_rates.tax_rate, 0) as tax_rate,
                                    stores.name as store_name,
                                    IFNULL(stock.quantity_available, 0) as quantity_available
                                FROM products
                                LEFT JOIN stock ON stock.product=products.id
                                LEFT JOIN stores ON stores.code=products.vendor
                                LEFT JOIN tax_rates ON products.tax_id=tax_rates.id
                                WHERE IFNULL(stock.quantity_available, 0) <= IFNULL(products.min_quantity, 0) AND products.store='$store'
                                ORDER BY products.name ASC
                              "
                              ) or die($conn->error);
    
                              while ($row = $res->fetch_assoc()) :
                              ?>
                                <tr>
                                  <td><?php echo $row['product_name']; ?></td>
                                  <td><?php echo $row['category']; ?></td>
                                  <td><?php echo $row['price']; ?></td>
                                  <td><?php echo $row['min_quantity']; ?></td>
                                  <td><?php echo $row['quantity_available']; ?></td>
                                  <td><?php echo $row['store_name']; ?></td>
                                  <td>
                                    <?php
                                      if($row['quantity_available'] <= $row['min_quantity']) {
                                        echo "<span style='color: red;'> Low </span>";
                                      } else {
                                        echo "<span style='color: green;'> Level Ok </span>";
                                      }
                                    ?>
                                  </td>
        
                                </tr>
                              <?php
                                
                                endwhile; }
                          
                          ?>
                          

                  </tbody>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
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

  <script type="text/javascript">

        function storeDataLoader(){
            let store = document.getElementById('store').value;
            window.location.href = "products_reorder_level.php?store="+store;
        }
        
    </script>
</body>

</html>