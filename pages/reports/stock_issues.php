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
<?php
include __DIR__.'/../partials/head.php';
?>
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
                <h3 class="card-title"> Salesman Issue Report </h3>
              </div>
           
  <form method="POST"  class="form-inline">
  <table>
  <tr>
     <td>          
                <div class="col-md-4">
                <div class="form-group">
                <label for="expense_for">Date From:</label>
                <input type="date" name="date_from" required value="<?php echo $from = $_POST['date_from'] ? $_POST['date_from'] : date(); ?>" class="form-control">
                    </div>
                  </div>
                    </td>
                    <td>
                  <div class="col-md-4">
                  <div class="form-group">
                  <label for="expense_for">Date To:</label>
                  <input type="date" name="date_to" required value="<?php echo $to = $_POST['date_to'] ? $_POST['date_to'] : date(); ?>" class="form-control">
                    </div>
                  </div>
                </div>
                </td>
                     <td> <label>Select Salesman:</label>
  <!--<td>  <select class="form-control" id="id" name="id" required>-->
		          <select class="form-control" id="name" name="id" required>

                <?php 

                  if(!isset($_POST['id']) or $_POST['id'] == "all") {

                    echo "<option value='all'>All Salesmen</option>";

                  } else{

                    $id = $_POST['id'];
                    $user = $conn->query("SELECT name FROM users where id='$id'") or die($conn->error); 
                    $column = $user->fetch_array();
                    
                    echo "<option selected value=".$_POST['id'].">".$column['name']."</option>";
                    echo "<option value='all'>All Salesmen</option>";

                  }

                ?>
                
                <?php
                $stores = $conn->query("SELECT id, name FROM users order by name") or die($conn->error);
                while ($row=$stores->fetch_assoc()) {
                  echo "<option value=".$row['id'].">".$row['name']."</option>";}
                    ?>
                  
            </select>
                                
            </td>


            <!--***********************Store****************************** -->
            <td> 
                <label>Select Store:</label>
		            <select class="form-control" id="id" name="store_code" required>

                      <?php 

                          if(!isset($_POST['store_code']) or $_POST['store_code'] == "all") {

                            echo "<option value='all'>All Stores</option>"; 

                          } else {

                            $store_code = $_POST['store_code'];
                            $user = $conn->query("SELECT name, id, code FROM stores where code='$store_code'") or die($conn->error); 
                            $column = $user->fetch_array();
                            echo "<option selected value=".$_POST['store_code'].">".$column['name']."</option>";
                            echo "<option value='all'>All Stores</option>"; 

                          }
                        ?> 
                  
                        <?php

                          $stores = $conn->query("SELECT id, code, name FROM stores order by name") or die($conn->error);
                          while ($row=$stores->fetch_assoc()) {
                            echo "<option value=".$row['code'].">".$row['name']."</option>";
                            
                          }

                        ?>
                </select>
                    
            </td>


 <td>
 <input type="submit" class="btn bg-info btn-block mt-4" id="submit_search" onclick="loader()" name="search" value=" Search">
 <?php// echo json_encode($_POST); ?>
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
                      <th>Product Name</th>
                      <th>Salesman</th>
                      <th>Unit Cost</th>
                      <th>Issued Quantity</th>
                      <th>Sold</th>
                      <th>Returned</th>
                  </tr>
                  </thead>
                  <tbody>
                     
                    <?php

                      $tot = [
                        "TOTAL_COST_PRICE" => 0,
                        "TOTAL_SELLING_PRICE" => 0,
                        "TOTAL_PROFIT" => 0
                      ];

                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                        if($_POST['id'] == 'all' and $_POST["store_code"] == "all") {
                            
                            $from = $_POST['date_from'];
                            $to = $_POST['date_to'];
                                
                            $res = $conn->query(

                                "SELECT 
                                  product_name, 
                                  SUM(sold) as sold, 
                                  SUM(returned) as returned, 
                                  SUM(issued_quantity) as issued_quantity, 
                                  unit_cost FROM
                                    (
                                     SELECT 
                                        store_owner,
                                        store_owner_name,
                                        product_name,
                                        -- product,
                                        salesman, 
                                        IFNULL(nsale.sold, 0) sold, 
                                        (IFNULL(stkmobile.issued_quantity, 0) - IFNULL(nsale.sold, 0)) returned,
                                        IFNULL(stkmobile.issued_quantity, 0) issued_quantity,
                                        IFNULL(stkmobile.unit_cost, 0) unit_cost FROM

                                        (
                                          SELECT `store_owner`, users.name as store_owner_name, products.price as unit_cost, `product`, products.name as product_name, SUM(`quantity_available`) AS issued_quantity
                                          FROM `stock_mobile`
                                          INNER JOIN products ON products.id=stock_mobile.product
                                          INNER JOIN users ON users.id=stock_mobile.store_owner
                                          WHERE `date` BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 	DAY) GROUP BY `store_owner`,`product`
                                            
                                        ) stkmobile
                                        
                                        LEFT OUTER JOIN
                                        
                                        (
                                            SELECT new_sale.salesman, new_sale.`product`, SUM(new_sale.quantity) AS sold
                                            FROM new_sale
                                            WHERE  new_sale.date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' 	 AS DATE), INTERVAL 1 DAY)
                                          GROUP BY  new_sale.`salesman`, new_sale.`product` ORDER BY new_sale.`product`
                                        ) nsale
                                        
                                        ON stkmobile.product = nsale.product AND stkmobile.store_owner=nsale.salesman
                                        ORDER BY stkmobile.product_name ASC
                                    ) inner_table
                                GROUP BY product_name, unit_cost
                                  "
                                  
                            ) or die($conn->error);

                            while ($row = $res->fetch_assoc()) {

                                echo "<tr>";

                                    // echo json_encode($row);
                                    // echo "<br>";
                                    
                                    echo "<td>".$row['product_name']."</td>";
                                    echo "<td>".""."</td>";
                                    echo "<td>".$row['unit_cost']."</td>";
                                    echo "<td>".$row['issued_quantity']."</td>";
                                    echo "<td>".$row['sold']."</td>";
                                    echo "<td>".$row['returned']."</td>";

                                echo "</tr>";
                                
                            } 

                        } else if($_POST['id'] !== 'all' and $_POST["store_code"] == "all") {

                            // collect value of input field
                            $id = $_POST['id'];
                            $from = $_POST['date_from'];
                            $to = $_POST['date_to'];
                            
                            $res = $conn->query(

                                "SELECT *, 
                                    IFNULL(nsale.sold, 0) sold, 
                                    (IFNULL(stkmobile.issued_quantity, 0) - IFNULL(nsale.sold, 0)) returned,
                                    IFNULL(stkmobile.issued_quantity, 0) issued_quantity,
                                    IFNULL(stkmobile.unit_cost, 0) unit_cost FROM
                                    (
                                      SELECT `store_owner`, users.name as store_owner_name, products.price as unit_cost, `product`, products.name as product_name, SUM(`quantity_available`) AS issued_quantity
                                      FROM `stock_mobile`
                                      INNER JOIN products ON products.id=stock_mobile.product
                                      INNER JOIN users ON users.id=stock_mobile.store_owner
                                      WHERE `date` BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 	DAY) GROUP BY `store_owner`,`product`
                                        
                                    ) stkmobile
                                    
                                    LEFT OUTER JOIN
                                    
                                    (
                                      SELECT new_sale.salesman, new_sale.`product`, SUM(new_sale.quantity) AS sold
                                      FROM new_sale
                                      WHERE  new_sale.date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' 	 AS DATE), INTERVAL 1 DAY)
                                      GROUP BY  new_sale.`salesman`, new_sale.`product` ORDER BY new_sale.`product`
                                    ) nsale
                                    
                                    ON stkmobile.product = nsale.product AND stkmobile.store_owner=nsale.salesman
                                    WHERE stkmobile.store_owner='$id'
                                    ORDER BY stkmobile.product_name ASC"

                            ) or die($conn->error);

                            while ($row = $res->fetch_assoc()) {

                                echo "<tr>";
                                    
                                    // echo json_encode($row);
                                    // echo "<br>";
                                    
                                    echo "<td>".$row['product_name']."</td>";
                                    echo "<td>".$row['store_owner_name']."</td>";
                                    echo "<td>".$row['unit_cost']."</td>";
                                    echo "<td>".$row['issued_quantity']."</td>";
                                    echo "<td>".$row['sold']."</td>";
                                    echo "<td>".$row['returned']."</td>";

                                echo "</tr>";  

                            } 
                            
                        } else if($_POST['id'] !== 'all' and $_POST["store_code"] !== "all") {

                            // collect value of input field
                            $id = $_POST['id'];
                            $from = $_POST['date_from'] ;
                            $to = $_POST['date_to'] ;

                            $store_code = $_POST["store_code"];
                            
                            $res = $conn->query(

                                "SELECT *,
                                  IFNULL(nsale.sold, 0) sold, 
                                  (IFNULL(stkmobile.issued_quantity, 0) - IFNULL(nsale.sold, 0)) returned,
                                  IFNULL(stkmobile.issued_quantity, 0) issued_quantity,
                                  IFNULL(stkmobile.unit_cost, 0) unit_cost FROM
                                (
                                  SELECT `store_owner`, users.name as store_owner_name, products.price as unit_cost, `product`, products.vendor, products.name as product_name, SUM(`quantity_available`) AS issued_quantity
                                  FROM `stock_mobile`
                                  INNER JOIN products ON products.id=stock_mobile.product
                                  INNER JOIN users ON users.id=stock_mobile.store_owner
                                  WHERE `date` BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 	DAY) GROUP BY `store_owner`,`product`
                                    
                                ) stkmobile
                                
                                LEFT OUTER JOIN
                                
                                (
                                  SELECT new_sale.salesman, new_sale.`product`, SUM(new_sale.quantity) AS sold
                                  FROM new_sale
                                  WHERE  new_sale.date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' 	 AS DATE), INTERVAL 1 DAY)
                                  GROUP BY  new_sale.`salesman`, new_sale.`product` ORDER BY new_sale.`product`
                                ) nsale
                                
                                ON stkmobile.product = nsale.product AND stkmobile.store_owner=nsale.salesman
                                WHERE stkmobile.store_owner='$id' AND stkmobile.vendor='$store_code'
                                ORDER BY stkmobile.product_name ASC"

                            ) or die($conn->error);

                            while ($row = $res->fetch_assoc()) {

                                echo "<tr>";

                                    // echo json_encode($row);
                                    // echo "<br>";
                                    
                                    echo "<td>".$row['product_name']."</td>";
                                    echo "<td>".$row['store_owner_name']."</td>";
                                    echo "<td>".$row['unit_cost']."</td>";
                                    echo "<td>".$row['issued_quantity']."</td>";
                                    echo "<td>".$row['sold']."</td>";
                                    echo "<td>".$row['returned']."</td>";

                                echo "</tr>";  

                            } 
                            
                        } else if($_POST['id'] == 'all' and $_POST["store_code"] !== "all") {

                            // collect value of input field
                            $id = $_POST['id'];
                            $from = $_POST['date_from'] ;
                            $to = $_POST['date_to'] ;

                            $store_code = $_POST["store_code"];
                            
                            $res = $conn->query(

                                "SELECT 
                                  product_name, 
                                  SUM(sold) as sold, 
                                  SUM(returned) as returned, 
                                  SUM(issued_quantity) as issued_quantity, 
                                  unit_cost FROM
                                    (
                                     SELECT 
                                        store_owner,
                                        store_owner_name,
                                        product_name,
                                        salesman, 
                                        IFNULL(nsale.sold, 0) sold, 
                                        (IFNULL(stkmobile.issued_quantity, 0) - IFNULL(nsale.sold, 0)) returned,
                                        IFNULL(stkmobile.issued_quantity, 0) issued_quantity,
                                        IFNULL(stkmobile.unit_cost, 0) unit_cost FROM
                                        (
                                          SELECT `store_owner`, users.name as store_owner_name, products.price as unit_cost, `product`, products.vendor, products.name as product_name, SUM(`quantity_available`) AS issued_quantity
                                          FROM `stock_mobile`
                                          INNER JOIN products ON products.id=stock_mobile.product
                                          INNER JOIN users ON users.id=stock_mobile.store_owner
                                          WHERE `date` BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 	DAY) GROUP BY `store_owner`,`product`
                                            
                                        ) stkmobile
                                        
                                        LEFT OUTER JOIN
                                        
                                        (
                                            SELECT new_sale.salesman, new_sale.`product`, SUM(new_sale.quantity) AS sold
                                            FROM new_sale
                                            WHERE  new_sale.date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' 	 AS DATE), INTERVAL 1 DAY)
                                          GROUP BY  new_sale.`salesman`, new_sale.`product` ORDER BY new_sale.`product`
                                        ) nsale
                                        
                                        ON stkmobile.product = nsale.product AND stkmobile.store_owner=nsale.salesman
                                        WHERE stkmobile.vendor='$store_code'
                                        ORDER BY stkmobile.product_name ASC
                                    ) inner_table
                                GROUP BY product_name, unit_cost
                                "

                            ) or die($conn->error);

                            while ($row = $res->fetch_assoc()) {

                                echo "<tr>";
                                                                        
                                    echo "<td>".$row['product_name']."</td>";
                                    echo "<td>".""."</td>";
                                    echo "<td>".$row['unit_cost']."</td>";
                                    echo "<td>".$row['issued_quantity']."</td>";
                                    echo "<td>".$row['sold']."</td>";
                                    echo "<td>".$row['returned']."</td>";
                                    
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
<!-- scripts -->
<?php include __DIR__.'/../partials/footer.php'; ?>
<!-- /.scripts -->

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
<?php 
  // SELECT 
  //   product_name, 
  //   salesman, 
  //   sale_date, 
  //   salesman_id, 
  //   unit_cost,
  //   sold,
  //   (quantity_added - sold) as returned,
  //   quantity_added as issued_quantity FROM
  //   (
  //       SELECT 
  //         products.name AS product_name,
  //         users.name AS salesman,
  //         users.id As salesman_id,
  //         new_sale.quantity as sold,
  //         new_sale.product as product_id,
  //         new_sale.date as sale_date,
  //         products.price as unit_cost
  //       FROM new_sale 
  //       INNER JOIN products ON products.id=new_sale.product
  //       INNER JOIN users ON users.id=new_sale.salesman
  //       WHERE new_sale.date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), 		INTERVAL 1 DAY)
  //       ORDER BY new_sale.date ASC
  //   ) sales_derived
  //   INNER JOIN 
  //   (
  //     SELECT store_owner, product, quantity_added FROM stock_mobile_additions
  //     WHERE date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL	1 DAY)
  //   ) stock_mobile_additions_ 
  //   ON sales_derived.product_id=stock_mobile_additions_.product 
  //   -- AND sales_derived.salesman=stock_mobile_additions_.store_owner
  //   ORDER BY product_name ASC
  //   -- LIMIT 100

    ?>

