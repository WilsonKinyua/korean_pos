<?php include '../utils/conn.php';
session_start();
if (!isset($_SESSION['group'])) {
    header('location: ../utils/logout.php');
} else {
    $username = $_SESSION['username'];
    $group = $_SESSION['group'];
}
?>
<!DOCTYPE html>
<html>
<!-- head -->
<?php include __DIR__ . '/../partials/head.php'; ?>
<!-- /.head -->

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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Account Payable Report</h3>
                                </div>

                                <form method="POST" class="form-inline">
                                    <table>
                                        <tr class="row">
                                            <td class="col-md-2">
                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <label for="expense_for">Date From:</label>
                                                        <input type="date" name="date_from" required value="<?php echo $from = $_POST['date_from'] ? $_POST['date_from'] : date(); ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-md-2">
                                                <div class="form-group w-100">
                                                    <label for="expense_for">Date To:</label>
                                                    <input type="date" name="date_to" required value="<?php echo $to = $_POST['date_to'] ? $_POST['date_to'] : date(); ?>" class="form-control w-100 ml-4">
                                                </div>
                                            </td>
                                            <td class="col-md-2">
                                                <label>Payment Type:</label>
                                                <select class="form-control ml-3" id="id" style="width: 90%" name="type" onchange="showDiv(this)" required>
                                                    <option value="" disabled selected>Select Type</option>
                                                    <option value="1" <?= (isset($_POST['type']) && $_POST['type'] == 1 ? 'selected' : '') ?>>Invoices</option>
                                                    <option value="2" <?= (isset($_POST['type']) && $_POST['type'] == 2 ? 'selected' : '') ?>>Payments</option>
                                                </select>
                                            </td>
                                            <td class="col-md-2" >
                                                <label>Select Supplier:</label>
                                                <select class="form-control" id="id" name="customer" required>
                                                    <option value='all'>All Suppliers</option>
                                                    <?php if ($group != 'Salesman') {
                                                        $query = "SELECT id,name FROM supplier ORDER By name ASC";
                                                        $res = $conn->query($query) or die($conn->error);
                                                        while ($row = $res->fetch_assoc()) {
                                                            if (isset($_POST['customer'])) {
                                                                $id = $_POST['customer'];
                                                                if ($row['id'] == $id) {
                                                                    echo  "<option value=" . $row['id'] . " selected> " . $row['name'] . "</option>";
                                                                } else {
                                                                    echo "<option value=" . $row['id'] . "> " . $row['name'] . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option value=" . $row['id'] . "> " . $row['name'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td class="col-md-2 form-group" style="display: none; padding-left: 100px;" id="hidden_div">
                                                <label>Invoice Type:</label>
                                                <select class="form-control ml-3 hidden_select" id="id" style="width: 90%" name="invoice_type" id="hidden_select" required>
                                                    <option value="all">All</option>
                                                    <option value="1" <?= (isset($_POST['type']) && $_POST['invoice_type'] == 1 ? 'selected' : '') ?>>Paid</option>
                                                    <option value="2" <?= (isset($_POST['type']) && $_POST['invoice_type'] == 2 ? 'selected' : '') ?>>Not Paid</option>
                                                </select>
                                            </td>
                                            <td class="col-md-1" style="padding-left: 100px;">
                                                <div class="col-12 d-flex justify-content-center mt-3">
                                                    <input type="submit" class="btn bg-info" id="submit_search" onclick="loader()" name="search" value=" Search">
                                                </div>
                                            </td>
                                            <td>
                                                <div id="load" class="loader"></div>
                                            </td>

                                        </tr>
                                    </table>
                                </form>
                                <hr>
                                <div style="overflow-x:auto;">
                                    <table id="Sales_table" class="table table-bordered table-striped" style="overflow-x:auto;">
                                        <thead>
                                            <?php
                                            if (!isset($_POST['type']) || empty($_POST['type']) || $_POST['type'] == 1) { ?>
                                                <tr>
                                                    <?php
                                                    if (isset($_POST['customer']) && $_POST['customer'] == 'all') {
                                                        echo "<th>Supplier</th>";
                                                    }
                                                    ?>
                                                    <th>Doc Number</th>
                                                    <th>Doc Date</th>
                                                    <th>Amount</th>
                                                    <th>Paid</th>
                                                    <th>Due Date</th>
                                                    <th>Created By</th>
                                                </tr>
                                            <?php
                                            } elseif ($_POST['type'] == 2) { ?>
                                                <tr>
                                                    <?php
                                                    if (isset($_POST['customer']) && $_POST['customer'] == 'all') {
                                                        echo "<th>Supplier</th>";
                                                    }
                                                    ?>
                                                    <th>Doc Number</th>
                                                    <th>Doc Date</th>
                                                    <th>Amount</th>
                                                    <th>Payment Mode</th>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </thead>
                                        <tbody>

                                            <?php

                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['customer'], $_POST['type'])) {

                                                if ($_POST['customer'] == 'all') {

                                                    $from = $_POST['date_from'];
                                                    $to = $_POST['date_to'];

                                                    if ($_POST['type'] == 1) { 
                                                        $inv_type = '';
                                                        if ($_POST['invoice_type'] == 1) {
                                                            $inv_type = ' AND i.status = 1';
                                                        } elseif ($_POST['invoice_type'] == 2) {
                                                            $inv_type = ' AND i.status = 0';
                                                        }
                                                        $que = "SELECT i.*, c.name, users.name as salesman FROM bills as i 
                                                            INNER JOIN supplier as c ON i.supplier_id=c.id 
                                                                LEFT JOIN users on users.id = i.supplier_id 
                                                                WHERE i.tran_date
                                                        BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)" . $inv_type;
                                                        $qry = $conn->query($que) or die($conn->error);


                                                        while ($row = $qry->fetch_assoc()) {

                                                            echo "<tr>";
                                                            echo "<td>" . $row['name'] . "</td>";
                                                            echo "<td>" . $row['reference'] . "</td>";
                                                            echo "<td>" . $row['tran_date'] . "</td>";
                                                            echo "<td>" . abs($row['total']) . "</td>";
                                                            echo "<td>" . ($row['status'] == 1 ? 'Yes' : 'No') . "</td>";
                                                            echo "<td>" . $row['due_date'] . "</td>";
                                                            echo "<td>" . $row["salesman"] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    } elseif ($_POST['type'] == 2) { 
                                                        $qry = $conn->query(
                                                            "SELECT ip.*, c.name FROM bill_payments as ip
                                                            LEFT JOIN bills as i on i.bill_payment_id = ip.id 
                                                            INNER JOIN supplier as c ON i.supplier_id= c.id 
                                                            WHERE ip.tran_date 
                                                        BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)"

                                                        ) or die($conn->error);


                                                        while ($row = $qry->fetch_assoc()) {

                                                            echo "<tr>";
                                                            echo "<td>" . $row['name'] . "</td>";
                                                            echo "<td>" . $row['reference'] . "</td>";
                                                            echo "<td>" . $row["tran_date"] . "</td>";
                                                            echo "<td>" . abs($row['total']) . "</td>";
                                                            echo "<td>" . $row['payment_type'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                } else {
                                                    $customer = $_POST['customer'];
                                                    $from = $_POST['date_from'];
                                                    $to = $_POST['date_to'];

                                                    if ($_POST['type'] == 1) { 

                                                        $qry = $conn->query(

                                                            "SELECT i.*, c.name, users.name as salesman FROM bills as i 
                                                            INNER JOIN supplier as c ON i.supplier_id=c.id 
                                                            LEFT JOIN users on users.id = i.user_id WHERE 
                                                            i.supplier_id = '$customer' AND
                                                            i.tran_date  BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)"

                                                        ) or die($conn->error);


                                                        while ($row = $qry->fetch_assoc()) {

                                                            echo "<tr>";
                                                            echo "<td>" . $row['reference'] . "</td>";
                                                            echo "<td>" . $row['tran_date'] . "</td>";
                                                            echo "<td>" . abs($row['total']) . "</td>";
                                                            echo "<td>" . ($row['status'] == 1 ? 'Yes' : 'No') . "</td>";
                                                            echo "<td>" . $row["salesman"] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    } elseif ($_POST['type'] == 2) { 

                                                        $qry = $conn->query(

                                                            "SELECT ip.*, c.name FROM bill_payments as ip
                                                            LEFT JOIN bills as i on i.bill_payment_id = ip.id 
                                                            INNER JOIN supplier as c ON i.supplier_id= c.id 
                                                            WHERE 
                                                                  i.supplier_id = '$customer' AND
                                                                  ip.tran_date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)"

                                                        ) or die($conn->error);


                                                        while ($row = $qry->fetch_assoc()) {

                                                            echo "<tr>";
                                                            echo "<td>" . $row['reference'] . "</td>";
                                                            echo "<td>" . $row["tran_date"] . "</td>";
                                                            echo "<td>" . abs($row['total']) . "</td>";
                                                            echo "<td>" . $row['payment_type'] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                            }

                                            "</tbody>";

                                            ?>

                                           
                                    </table>
                                </div>
                            </div>
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
    <?php include __DIR__ . '/../partials/footer.php'; ?>
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
    <?php include __DIR__ . '/../partials/scripts.php'; ?>
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
        $(function() {
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
        function showDiv(select){
            if(select.value==1){
                document.getElementById('hidden_div').style.display = "block";
            } else{
                document.getElementById('hidden_div').style.display = "none";
            }
        } 

    </script>

</body>

</html>