<?php include '../utils/conn.php';
session_start();
if (!isset($_SESSION['group'])) {
  header('location: ../utils/logout.php');
}else{
  $username = $_SESSION['username'];
  $group = $_SESSION['group'];
}
 ?>
<!DOCTYPE  html>
<html>
<!-- head -->
<?php 

  include __DIR__.'/../partials/head.php'; 

?>
<!-- /.head -->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include __DIR__.'/../partials/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include __DIR__.'/../partials/sidebar.php'; ?>
    <!--    end sidebar-->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pt-4">

      <?php 

          // if(!isset($_GET["invoice"]) or empty($_GET["invoice"])) { header("location: aging_receivables.php"); } header("location: payment.php?doc=".$doc_number);
          $invoice_id = $_GET["invoice"];
          // echo "---------------------->>>>>>>>>>>>>>>>>>>>>>>>".$invoice_id;
          $res = $conn->query(
            "SELECT 
              invoices.id as invoice_id,
              invoices.due_date,
              invoices.tran_date,
              invoices.reference,
              invoices.status,
              invoices.customer_id,
              invoices.invoice_payment_id,
              invoices.salesman_id,
              invoices.total as amount,
              users.name as salesman_name,
              customers.cust_name as customer_name,
            DATEDIFF(CURDATE(), invoices.due_date) as days
            FROM invoices
            INNER JOIN invoice_lines ON invoice_lines.invoice_id=invoices.id
            INNER JOIN users ON users.id=invoices.salesman_id
            INNER JOIN customers ON invoices.customer_id=customers.id
            WHERE invoices.id='$invoice_id'
            "
          ) or die($conn->error);

          $invoice = $res->fetch_array();

      ?>

        <div class="row">
          <div class="col-md-3">
            <div class="row text-primary">Customer</div>
            <div class="row"><?php echo $invoice["customer_name"] ?></div>   
          </div>
          <div class="col-md-3">
            <div class="row text-primary">Invoice Ref No</div>
            <div class="row"><?php echo $invoice["reference"] ?></div>
          </div>
          <div class="col-md-3">
            <div class="row text-primary">Amount</div>
            <div class="row"><?php echo $invoice["amount"] ?></div>
          </div>
          <div class="col-md-3">
            <div class="row text-primary">Doc Date</div>
            <div class="row"><?php echo $invoice["tran_date"] ?></div>
          </div>
        </div>

        <div class="row mb-4 mt-3">
          <div class="col-md-3">
            <div class="row text-primary">Due Date</div>
            <div class="row"><?php echo $invoice["due_date"] ?></div>   
          </div>
          <div class="col-md-3">
            <div class="row text-primary">Overdue Days</div>
            <div class="row">
              <?php
                if($invoice["days"] <= 0) {
                  echo 0;
                } else {
                  echo $invoice["days"];
                }
              ?>
            </div>
          </div>
          <!-- <div class="col-md-3">
            <div class="row">Amount</div>
            <div class="row"></div>
          </div>
          <div class="col-md-3">
            <div class="row">Doc Date</div>
            <div class="row"></div>
          </div> -->
        </div>

        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Products</h3>
              </div>
           
 
                <hr>
                <div  style="overflow-x:auto;">
                <table id="Sales_table" class="table table-bordered table-striped"  style="overflow-x:auto;">
                  <thead>
                    <tr>

                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Line Amount</th>
                      <th>Line Tax Total</th>
                  </tr>
                  </thead>
                  <tbody>
                     
                  <?php
                    
                    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        $res = $conn->query(
                          
                            "SELECT 
                                invoice_lines.id as invoice_line_id,
                                invoice_lines.quantity,
                                products.name,
                                invoice_lines.line_tax_total,
                                invoice_lines.line_amount
                            FROM `invoice_lines`
                            INNER JOIN products ON products.id=invoice_lines.product
                            WHERE invoice_lines.invoice_id='$invoice_id'
                            "

                        ) or die($conn->error);

                        while ($row = $res->fetch_assoc()) {

                          echo "<tr>";

                              // echo json_encode($row);

                              echo "<td>".$row['name']."</td>";
                              echo "<td>".$row['quantity']."</td>";
                              echo "<td>".$row['line_amount']."</td>";
                              echo "<td>".$row['line_tax_total']."</td>";
                              
                          echo "</tr>";
                          
                        } 

                    // }  
                    
                  "</tbody>";
                  "<tfoot>";
                       
                   echo  "<tr>";

                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";

                   echo  "</tr>";

                  echo  " </tfoot>";
                  
                  ?>
                </table>
               
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
<!-- footer -->
<?php include __DIR__.'/../partials/footer.php'; ?>
<!-- /.footer -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
   <!--./wrapper -->

<!--<p>Click the button to print the current page.</p>-->

<!-- footer -->
<?php include __DIR__.'/../partials/scripts.php'; ?>
<!-- /.footer -->


 <!--DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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

 <!--Page specific script -->
<script type="text/javascript">
$(function () {

  let table = $('#Sales_table').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "dom": 'Bfrtip',
      "buttons": [
          // 'print', 'excel', 'pdf'
      ]
  });

  table.buttons().container()
  .appendTo( '#example_wrapper .col-md-6:eq(0)' );

});
</script>
 
  </body>
  </html>
