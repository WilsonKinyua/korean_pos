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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ageing Payables Report</h3>
              </div>


              <form method="POST"  class="form-inline">
                <table>
                <tr>
                  <td>          
                  <div class="col-md-4">
                  <div class="form-group">
                  <label for="expense_for"> Date As Of: </label>
                  <input type="date" required name="date_from" value="<?php echo $result = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-d'); ?>" max="<?php // echo date('Y-m-d'); ?>" class="form-control">
                      </div>
                    </div>
                      </td>
                      <td>
                  </div>
                  </td>
              <!--***********************Store****************************** -->
                <td > 
                  <label class="text-center">Select Customer:</label>
                  <select class="form-control" id="id" name="supplier_id">

                        <?php 

                            if(!isset($_POST['supplier_id']) or $_POST['supplier_id'] == "all") {

                              echo "<option value='all'> All Supplier </option>"; 

                            } else {

                              $supplier_id = $_POST['supplier_id'];
                              $supplier = $conn->query("SELECT name, id FROM supplier where id='$supplier_id'") or die($conn->error); 
                              $column = $supplier->fetch_array();
                              echo "<option selected value=".$_POST['supplier_id'].">".$column['name']."</option>";
                              echo "<option value='all'>All Suppliers</option>";

                            }
                          ?> 
                    
                          <?php

                            $stores = $conn->query("SELECT id, name FROM supplier order by name") or die($conn->error);

                            while ($row=$stores->fetch_assoc()) {

                              echo "<option value=".$row['id'].">".$row['name']."</option>";
                              
                            }

                          ?>
                      </select>
                      
                      </td>


                <td>
                  <input type="submit" class="btn mt-4 bg-info btn-block" id="submit_search" onclick="loader()" name="search" value=" Search">
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
                      <th>Supplier Name</th>
                      <th>Invoice Ref No</th>
                      <th>Amount</th>
                      <th>Doc Date</th>
                      <th>Due Date</th>
                      <th>Overdue Days</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                     
                  <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                    
                      $from = $_POST['date_from'];
                      $supplier_id = $_POST['supplier_id'];

                      if(!empty($from) and $supplier_id == "all") {

                          $res = $conn->query(
                              "SELECT 
                                bills.id as bill_id,
                                bills.due_date,
                                bills.reference,
                                bills.status,
                                bills.supplier_id,
                                bills.bill_payment_id,
                                bills.user_id,
                                bills.tran_date,
                                bills.total as amount,
                                supplier.name as supplier_name,
                                users.name as salesman_name,
                                DATEDIFF('$from', bills.due_date) as days
                            FROM bills
                            INNER JOIN supplier ON supplier.id=bills.supplier_id
                            INNER JOIN users ON users.id=bills.user_id
                            WHERE bills.status=0
                            ORDER BY DATEDIFF('$from', bills.due_date) ASC"

                          ) or die($conn->error);

                          while ($row = $res->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>".$row['supplier_name']."</td>";
                                echo "<td>".$row['reference']."</td>";
                                echo "<td>".abs($row['amount'])."</td>";
                                echo "<td>".$row['tran_date']."</td>";
                                echo "<td>".$row['due_date']."</td>";
                                if($row['days'] <= 0) {
                                  echo "<td> 0 Day/s </td>";
                                } else {
                                  echo "<td>".$row['days']." Day/s </td>";
                                }
                                echo "<td> <button onclick='openModal(".$row['bill_id'].")' class='btn btn-success'  > More </button> </td>";
                            echo "</tr>";
                            
                          } 

                      } else if(!empty($from) and $supplier_id !== "all") { 

                          $res = $conn->query(
                            "SELECT 
                              bills.id as bill_id,
                              bills.due_date,
                              bills.reference,
                              bills.status,
                              bills.supplier_id,
                              bills.bill_payment_id,
                              bills.user_id,
                              bills.tran_date,
                              bills.total as amount,
                              supplier.name as supplier_name,
                              users.name as salesman_name,
                              DATEDIFF('$from', bills.due_date) as days 
                          FROM bills
                          INNER JOIN supplier ON supplier.id=bills.supplier_id
                          INNER JOIN users ON users.id=bills.user_id
                          WHERE bills.status=0 AND bills.supplier_id='$supplier_id'
                          ORDER BY DATEDIFF('$from', bills.due_date) ASC" 

                        ) or die($conn->error);

                        while ($row = $res->fetch_assoc()) {
                          echo "<tr>";
                              echo "<td>".$row['supplier_name']."</td>";
                              echo "<td>".$row['reference']."</td>";
                              echo "<td>".abs($row['amount'])."</td>";
                              echo "<td>".$row['tran_date']."</td>";
                              echo "<td>".$row['due_date']."</td>";
                              if($row['days'] <= 0) {
                                echo "<td> 0 Day/s </td>";
                              } else {
                                echo "<td>".$row['days']." Day/s </td>";
                              }
                              echo "<td> <button onclick='openModal(".$row['bill_id'].")' class='btn btn-success'  > More </button> </td>";
                          echo "</tr>";
                          
                        }

                      }

                    } 
                    
                  "</tbody>";
                  "<tfoot>";
                       
                   echo  "<tr>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                     echo  "<th></th>";
                    //  echo  $total = !isset($tot) ? "<th> 0 </th>" : "<th>".$tot['TOTAL']."</th>";
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


  <div style="display: none;" id="modal-here" class="container">
    <div class="row">
      <div style="border-top-right-radius: 10px; border-top-left-radius: 10px;" class="col-8 offset-2 pt-2 pb-2 bg-white">
        <b><h5>Bills More Details</h5></b>
      </div>
    </div>
    <div class="row">
      <div style="border-bottom-right-radius: 10px; border-bottom-left-radius: 10px;" class="col-8 offset-2 bg-white"> 
      
      <table id="Sales_table" class="table table-bordered table-striped"  style="overflow-x:auto;">
                  <thead>
                    <tr>

                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Line Amount</th>
                      <th>Line Tax Total</th>
                  </tr>
                  </thead>
                  <tbody id="table">
                                             
                  </tbody>
                  <tfoot>
                    <tr>

                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                   </tr>

                   </tfoot>
                  
                </table>
      
       </div>
    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/custombox/4.0.3/custombox.min.js" integrity="sha512-gVIaVnvXgOhn93qR/PhWTnwwftSFUcIgZ0KdkuvrFiN4fDct6oQv/6KcoWoi00TKL/b9S3AI8WNTb+3dlpEq3w==" crossorigin="anonymous"></script>

<!-- Datatables Buttons End -->

 <!--Page specific script -->
<script type="text/javascript">

function openModal(bill_id) {
  var modal = new Custombox.modal({
      content: {
        effect: 'fadein',
        target: '#modal-here'
      }
   });

   $.ajax(
    {
        type: "POST",
        dataType: 'json',
        url: "bills_more_details_ajax.php",
        data: {
          bill_id: bill_id
        }, 
        success: function(data) {
          $('#table').html(data.results);
        }
    });

   modal.open();
}


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
          'print', 'excel', 'pdf'
      ]
  });

  table.buttons().container()
  .appendTo( '#example_wrapper .col-md-6:eq(0)' );

});
</script>
 
  </body>
  </html>
