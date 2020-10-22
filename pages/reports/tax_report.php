<?php 

  include '../utils/conn.php';
  
  // ini_set('display_errors', 1);
  // error_reporting(E_ALL);

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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tax Report </h3>
              </div>
           
        <form method="POST"  class="form-inline">
          <table>
            <tr>
                  <td>          
                    <div class="col-md-4">
                      <div class="form-group">
                        <label
                        for="expense_for">Date From:</label>
                        <input type="date" 
                          name="date_from"
                          required 
                          value="<?php echo $from = $_POST['date_from'] ? $_POST['date_from'] : date('Y-m-d'); ?>" 
                          class="form-control">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="col-md-4">
                    <div class="form-group">
                    <label for="expense_for">Date To:</label>
                    <input type="date" name="date_to" required value="<?php echo $to = $_POST['date_to'] ? $_POST['date_to'] : date('Y-m-d'); ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                </td>
                <td> 

                <label class="text-left"> Tax Type: </label>
                <select class="form-control" id="name" name="tax_type" required>

                  <?php if(isset($_POST['tax_type']) and $_POST['tax_type'] == 1): ?>

                    <option selected value="1">Output Tax</option>
                    <option value="2"> Input Tax (Purchases) </option>
                    <option value="3"> Input Tax (Bills) </option>

                  <?php elseif(isset($_POST['tax_type']) and $_POST['tax_type'] == 2): ?>

                    <option value="1">Output Tax</option>
                    <option selected value="2"> Input Tax (Purchases) </option>
                    <option value="3"> Input Tax (Bills) </option>

                  <?php else: ?>

                    <option value="1">OutPut Tax</option>
                    <option value="2">Input Tax (Purchases)</option>
                    <option selected value="3"> Input Tax (Bills) </option>

                  <?php endif; ?>

                </select>
            
              </td>


 <td>
 <input type="submit" class="btn bg-info btn-block mt-4" id="submit_search" onclick="loader()" name="search" value=" Search">
 </td>
 <td><div id="load" class="loader"></div></td>
 
</tr>
</table>
</form>	
                  
                <hr>
                <div  style="overflow-x:auto;">
                <table id="Sales_table" class="table table-bordered table-striped"  style="overflow-x:auto;">
                  <thead>
                    
                      <tr>
                  
                        <th> Ref No </th>
                        <th>Transanction Date</th>
                        <th> Amount</th>
                        <th> Tax</th>
                      </tr>
                    
                  </thead>
                  <tbody>
                     
                    <?php

                      $total_amount = 0;
                      $total_tax = 0;

                      if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        if($_POST['tax_type'] == 1) {

                              $from = $_POST['date_from'] ;
                              $to = $_POST['date_to'];
                                
                              $res = $conn->query(
                                "SELECT 
                                    invoices.id as invoice_id,
                                    DATE(invoices.tran_date) as tran_date,
                                    invoices.reference as invoice_ref_number,
                                    invoices.total,
                                    SUM(IFNULL(invoice_lines.line_tax_total, 0)) as invoice_total_tax
                                FROM invoices
                                LEFT JOIN invoice_lines ON invoice_lines.invoice_id=invoices.id
                                WHERE invoices.tran_date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)
                                GROUP BY invoices.id, invoices.tran_date, invoices.reference, invoices.total"
                              ) or die($conn->error);

                              while ($row = $res->fetch_assoc()) {

                                $total_amount += $row['total'];
                                $total_tax += $row['invoice_total_tax'];

                                // echo "<tr>";
                                // echo json_encode($row);
                                // echo "<br>";
                              
                                  echo "<td>".$row['invoice_ref_number']."</td>";
                                  echo "<td>".$row['tran_date']."</td>";
                                  echo "<td>".number_format($row['total'], 2)."</td>";
                                  echo "<td>".number_format($row['invoice_total_tax'], 2)."</td>";

                                echo "</tr>";
                                
                              } 
                        } else if($_POST['tax_type'] == 2) {

                              // collect value of input field
                              $from = $_POST['date_from'];
                              $to = $_POST['date_to'] ;
                              // $tax_type = $_POST["tax_type"];
                                
                              $res = $conn->query(

                                  "SELECT 
                                      -- stock_detail.id as stock_detail_id,
                                      stock_detail.doc_number,
                                      stock_detail.date as tran_date,
                                      SUM(IFNULL(stock_detail.total_amount, 0)) as total_amount,
                                      SUM(IFNULL(stock_detail.line_tax_total, 0)) as tax
                                  FROM `stock_detail`
                                  WHERE date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to ' AS DATE), INTERVAL 1 DAY)
                                  GROUP BY stock_detail.doc_number, stock_detail.date
                                  "

                              ) or die($conn->error);

                              while ($row = $res->fetch_assoc()) {

                                $total_amount += $row['total_amount'];
                                $total_tax += $row['tax'];

                                echo "<tr>";

                                // echo json_encode($row);
                                // echo "<br>";

                                  echo "<td>".$row['doc_number']."</td>";
                                  echo "<td>".$row['tran_date']."</td>";
                                  echo "<td>".number_format($row['total_amount'], 2)."</td>";
                                  echo "<td>".number_format($row['tax'], 2)."</td>";

                                echo "</tr>"; 

                              } 
                            
                        } else if($_POST['tax_type'] == 3) {
                          
                                $from = $_POST['date_from'] ;
                                $to = $_POST['date_to'];
                                  
                                $res = $conn->query(
                                  "SELECT 
                                      bills.id as bill_id,
                                      DATE(bills.tran_date) as tran_date,
                                      bills.reference as ref_number,
                                      bills.total,
                                      SUM(IFNULL(bill_lines.line_tax_total, 0)) as bills_total_tax
                                      FROM bills
                                      LEFT JOIN bill_lines ON bill_lines.bill_id=bills.id
                                  WHERE bills.tran_date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)
                                  GROUP BY bills.id, bills.tran_date, bills.reference, bills.total"
                                ) or die($conn->error);
  
                                while ($row = $res->fetch_assoc()) {
  
                                  $total_amount += $row['total'];
                                  $total_tax += $row['bills_total_tax'];
  
                                  // echo "<tr>";
                                  // echo json_encode($row);
                                  // echo "<br>";
                                
                                    echo "<td>".$row['ref_number']."</td>";
                                    echo "<td>".$row['tran_date']."</td>";
                                    echo "<td>".number_format(abs($row['total']), 2)."</td>";
                                    echo "<td>".number_format($row['bills_total_tax'], 2)."</td>";
  
                                  echo "</tr>";
                                  
                                } 
                        }

                      }

                  "</tbody>";
                  "<tfoot>";
                       
                   echo  "<tr>";
                 
                    echo  "<th></th>";
                    echo  "<th></th>";
                    echo  "<th>".number_format(abs($total_amount), 2)."</th>";
                    echo  "<th>".number_format($total_tax, 2)."</th>";

                   echo  "</tr>";

                  echo  " </tfoot>";
                  
              ?>
                </table>
               
            <!-- <div class="col-sm-12">
            <button type="button" class="btn btn-primary pull-right" aria-label="Print" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
            </div> -->
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

<!-- scripts -->
<?php include __DIR__.'/../partials/scripts.php'; ?>
<!-- /.scripts -->

 <!--DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
 <!--Page specific script -->


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
$(function () {
  $('#Sales_table').DataTable({
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
 
  </body>
  </html>