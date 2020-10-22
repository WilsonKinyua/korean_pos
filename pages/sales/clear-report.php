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
<?php include __DIR__.'/../partials/head.php'; ?>
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
                                <h3 class="card-title">Cleared Stock Report</h3>
                            </div>

                            <form method="POST"  class="form-inline">
                                <table>
                                    <tr class="row">
                                        <td class="col-md-3">
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="expense_for">Date From:</label>
                                                    <input type="date" name="date_from" required value="<?php echo $from = $_POST['date_from'] ? $_POST['date_from'] : date(); ?>" class="form-control">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-3">
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label for="expense_for">Date To:</label>
                                                    <input type="date" name="date_to" required value="<?php echo $to = $_POST['date_to'] ? $_POST['date_to'] : date(); ?>" class="form-control">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-3">
                                            <label>Select Salesman:</label>
                                            <select class="form-control" id="id" name="id" required>
                                                <option value='all'>All Salesmen</option>
                                                <?php

                                                $salesmen_group = 7;

                                                $stores = $conn->query("SELECT id, name FROM users WHERE user_group='$salesmen_group'") or die($conn->error);

                                                while ($row=$stores->fetch_assoc()) {

                                                    if (isset($_POST['id'])) {

                                                        if ($row['id'] == $_POST['id']) {

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

                                        </td>


                                        <td class="col-md-3">
                                            <div class="col-12 d-flex justify-content-center mt-3">
                                                <input type="submit" class="btn bg-info" id="submit_search" onclick="loader()" name="search" value=" Search">
                                            </div>
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
                                    <?php
                                    if (isset($_POST['id']) && $_POST['id']== 'all'){
                                        echo "<th>Store Owner</th>";
                                    }
                                    ?>
                                    <th>Product Name</th>
                                    <th>Quantity Issued</th>
                                    <th>Quantity Sold</th>
                                    <th>Returned</th>
                                    <th>Sales</th>
                                    <th>Cleared</th>
                                    <th>Cleared By</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {

                                    if($_POST['id'] == 'all') {

                                        $from = $_POST['date_from'];
                                        $to = $_POST['date_to'] ;

                                        // Total Calculation
                                        $qry = $conn->query(

                                            "SELECT *,products.name as product, users.name as store_owner FROM stock_mobile INNER JOIN products ON stock_mobile.product=products.id LEFT JOIN users on users.id = stock_mobile.store_owner WHERE date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)"

                                        ) or die($conn->error);


                                        while ($row = $qry->fetch_assoc()) {

                                            $approvedBy = '';
                                            if (isset($row["approved_by"]) && !empty($row["approved_by"])) {
                                                $uid = $row["approved_by"];
                                                $us = $conn->query("SELECT name FROM users where id='$uid'");
                                                $approvedBy = $us->fetch_assoc()['name'];
                                            }

                                            echo "<tr>";
                                            echo "<td>".$row['store_owner']."</td>";
                                            echo "<td>".$row['product']."</td>";

                                            echo "<td>".$row['quantity_available']."</td>";
                                            echo "<td>".$row['sold']."</td>";

                                            echo "<td>".($row['quantity_available'] - $row['sold'])."</td>";
                                            echo "<td>".$row['sold']*$row['stockist']."</td>";
                                            echo "<td>".($row['clear_status'] == 1 ? 'Yes' : 'No')."</td>";
                                            echo "<td>" . $approvedBy . "</td>";
                                            echo "</tr>";

                                        }
                                    } else{
                                        $storeOwner = $_POST['id'];
                                        $from = $_POST['date_from'];
                                        $to = $_POST['date_to'] ;

                                        $qry = $conn->query(

                                            "SELECT * FROM stock_mobile INNER JOIN products ON stock_mobile.product=products.id  WHERE stock_mobile.store_owner = '$storeOwner' AND date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)"

                                        ) or die($conn->error);


                                        while ($row = $qry->fetch_assoc()) {

                                            $approvedBy = '';
                                            if (isset($row["approved_by"]) && !empty($row["approved_by"])) {
                                                $uid = $row["approved_by"];
                                                $us = $conn->query("SELECT name FROM users where id='$uid'");
                                                $approvedBy = $us->fetch_assoc()['name'];
                                            }


                                            echo "<tr>";
                                            echo "<td>" . $row['name'] . "</td>";

                                            echo "<td>" . $row['quantity_available'] . "</td>";
                                            echo "<td>" . $row['sold'] . "</td>";

                                            echo "<td>" . ($row['quantity_available'] - $row['sold']) . "</td>";
                                            echo "<td>" . $row['sold'] * $row['stockist'] . "</td>";
                                            echo "<td>" . ($row['clear_status'] == 1 ? 'Yes' : 'No') . "</td>";
                                            echo "<td>" . $approvedBy . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                }

                                "</tbody>";

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
