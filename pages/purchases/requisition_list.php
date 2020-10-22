<?php
session_start();
include '../utils/conn.php';
$total = 0;
include 'requisition_process.php';

if (isset($_POST['update_cart'])) {

    foreach ($_POST['quantity_supplied'] as $requisition_line_id => $value) {
        foreach ($_POST['price'] as $price => $newvalue) {
            $product_id = array_keys($value)[0];
            $quantity_supplied = $value[$product_id];

            $product_id_new = array_keys($newvalue)[0];
            $price = $newvalue[$product_id_new];

            $line_amount = $quantity_supplied * $price;

            $res = $conn->query("SELECT quantity_supplied FROM requisition_lines  WHERE id = '$requisition_line_id'") or die($conn->error);

            if ($res->num_rows > 0) {
                $db_quantity_supplied = (int) $res->fetch_assoc()['quantity_supplied'];
                if ((int)$quantity_supplied != $db_quantity_supplied) {
                    $query = $conn->query("UPDATE requisition_lines SET quantity_supplied = '$quantity_supplied',line_amount = '$line_amount' WHERE id = '$requisition_line_id'");

                    $results = $conn->query("SELECT requisition.*, requisition_lines.*, products.name as product_name,products.price as price, requisition_lines.id as sid,requisition_lines.product as product_id FROM requisition_lines 
                LEFT JOIN requisition ON requisition_lines.requisition_id=requisition.id LEFT JOIN products on requisition_lines.product = products.id WHERE requisition_lines.id = '" .  $requisition_line_id . "'");

                    while ($row = $results->fetch_assoc()) {

                        $subtotal = $quantity_supplied * $price;
                        $totalprice += $subtotal;
                        $id = $row['product_id'];
                        $quantity = $quantity_supplied;
                        $supplier = $row['supplier_id'];
                        $doc_number = $row['reference'];
                        $date = date('Y,m,d');

                        $conn->query("INSERT INTO `stock_detail`(`store`,`entity`, `doc_number`, `product`, `trn_qty`, `total_amount`,`trn_type`,`bal_qty`,`date`,`audituser`) 
                VALUES ('$supplier','$supplier','$doc_number','$id','$quantity','$subtotal','1','0','$date','$username')") or die($conn->error);
                    }

                    $additional_stock = (int)$quantity_supplied - $db_quantity_supplied;
                    //update stock
                    //Check if the product stock exists
                    $res = $conn->query("SELECT quantity_available FROM stock WHERE product='$product_id'") or die($conn->error);

                    if (mysqli_num_rows($res) > 0) {

                        // Update Stock
                        $conn->query("UPDATE `stock` SET `quantity_available`= quantity_available + '$additional_stock'  WHERE product='$product_id'") or die($conn->error);
                    } else {
                        //insert stock
                        $conn->query("INSERT INTO `stock`(`product`, `quantity_available`,`date`) VALUES ('$product_id','$additional_stock', CURDATE())") or die($conn->error);
                    }
                }
            }
        }
    }
    //set sessions or cookies here

    header("Location: requisition_list.php");
    exit();
}


?>
<?php
if (!isset($_SESSION['group'])) {
    header('location: ../utils/logout.php');
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


        <script type="text/javascript">
            function pickCost() {
                var customer = document.getElementById('customer').value;
                window.location.href = "requisition_list.php?customer=" + customer;
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

                        <div class="col-md-12">
                            <div class="card card-primary mt-5">
                                <div class="card-header">
                                    <h3 class="card-title">Requisition List</h3>
                                </div>
                                <div class="col-md-12">
                                    <form method="POST" class="form-inline">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="expense_for">Date From:</label>
                                                            <input type="date" name="date_from" required class="form-control" value="<?= isset($_POST['date_from']) ? $_POST['date_from'] : '' ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="expense_for">Date To:</label>
                                                            <input type="date" name="date_to" required class="form-control" value="<?= isset($_POST['date_to']) ? $_POST['date_to'] : '' ?>">
                                                        </div>
                                                    </div>
                                </div>
                                </td>

                                <td>
                                    <input type="submit" class="btn bg-info btn-block" id="submit_search" onclick="loader()" name="search" value=" Search">
                                </td>
                                <td>
                                    <div id="load" class="loader"></div>
                                </td>

                                </tr>
                                </table>
                                </form>
                            </div>
                            <form role="form" action="requisition_list.php" method="POST">
                                <input type="hidden" name="salesman" value="<?php echo $username; ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <script src="js/jquery.min.js"></script>
                                            <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
                                            <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                                            <script>
                                                $(document).ready(function(e) {

                                                    $("#suggestion_textbox").autocomplete({
                                                        source: 'search.php'
                                                    });

                                                });
                                                $('#suggestion_textbox').on('keypress', function(e) {
                                                    var code = e.keyCode || e.which;
                                                    if (code == 13) {
                                                        e.preventDefault();
                                                        let name = $("#suggestion_textbox").val();
                                                        window.location.href = "requisition_list.php?page=products&action=add&name=" + name;
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-0">
                                    <style>
                                        .dataTables_length,
                                        .dataTables_filter {
                                            margin-left: 40px;
                                            float: left;
                                        }
                                    </style>
                                    <div class="col-md-12 ml-2">
                                        <form method="post" action="requisition_list.php">
                                            <table id="example1" class="table table-bordered table-striped col-md-11" style="width: 100%; margin-left: 2em;">
                                                <thead>
                                                    <tr>
                                                        <th>Requisition No</th>
                                                        <th>Date</th>
                                                        <th>Product</th>
                                                        <th>Qty</th>
                                                        <th>Qty Supplied</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_body">
                                                    <?php

                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                                        $from = $_POST['date_from'];
                                                        $to = $_POST['date_to'];

                                                        $res = $conn->query("SELECT requisition.*, requisition_lines.*, products.name as product_name, products.price as price, requisition_lines.line_amount as line_amount, requisition_lines.id as sid FROM requisition_lines 
                    LEFT JOIN requisition ON requisition_lines.requisition_id=requisition.id LEFT JOIN products on requisition_lines.product = products.id WHERE requisition.tran_date BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 DAY)");

                                                        while ($row = $res->fetch_assoc()) {

                                                            $total += $row['line_amount'];
                                                            echo "<tr>";
                                                            echo "<td>" . $row['reference'] . "</td>";
                                                            echo "<td>" . $row['tran_date'] . "</td>";
                                                            echo "<td>" . $row['product_name'] . "</td>";
                                                            echo "<td>" . $row['quantity'] . "</td>";
                                                            echo "<td><input type='text' size='5' name='quantity_supplied[" . $row['sid'] . "][" . $row['product'] . "]' id='quantity_supplied' value='" . $row['quantity_supplied'] . "'></td>";
                                                            echo "<td><input type='text' size='5' name='price[" . $row['sid'] . "][" . $row['product'] . "]' id='price' value='" .  $row['price']  . "'></td>";
                                                            echo "<td>" . ($row['status'] == 1 ? 'Received' : 'Pending') . "</td>";
                                                            echo "<td>" . number_format($row['line_amount'], 1) . "</td>";
                                                            echo  " <th></th>";
                                                            echo " </tr>";
                                                        }
                                                    }
                                                    echo "</tbody>";
                                                    "<tfoot>";

                                                    echo  "<tr>";
                                                    echo  " <th></th>";
                                                    echo  " <th></th>";
                                                    echo  "<th></th>";
                                                    echo  "<th></th>";
                                                    echo  "<th></th>";
                                                    echo  "<th></th>";
                                                    echo  "<th>Total Amount</th>";
                                                    echo  "<th>" . (isset($total) ? number_format($total, 1) : '') . "</th>";
                                                    echo  "</tr>";

                                                    echo  " </tfoot>";
                                                    ?>
                                                </tbody>
                                            </table>
                                            <input type="submit" name="update_cart" class="btn btn-primary" style="margin-left: 4em;" value="Save Purchase"></input>
                                            <input type="submit" name="save_print" class="btn btn-primary" style="margin-left: 4em;" value="Save and Print Purchase"></input>
                                        </form>
                                    </div>
                                </div>

                                <hr>
                                <!-- /.card-body -->
                        </div>
                        </form>
                        <?php
                        if (isset($_SESSION['dont_close_alert'])) { ?>
                            <button hidden id="print" onclick="window.open('invoice_print.php?invoice_id=<?= $_SESSION['dont_close_alert'] ?>', '_blank');"></button>
                        <?php }
                        ?>
                    </div>
                </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include __DIR__ . '/../partials/scripts.php'; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>



    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <?php
    include_once '../partials/sidebar-js.php';
    ?>

    <script>
        $(document).ready(function(e) {

            $("#suggestion_textbox").autocomplete({
                source: 'search.php'
            });

            $('#suggestion_textbox').on('keypress', function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    let name = $("#suggestion_textbox").val();
                    window.location.href = "requisition_list.php?page=products&action=add&name=" + name;
                }
            });

        });

        $(".alert:not(.dont-close)").fadeTo(8000, 500).slideUp(500, function() {
            $(".alert:not(.dont-close)").slideUp(500);
        });

        <?php
        if (isset($_SESSION['dont_close_alert'])) { ?>
            $('button#print').trigger('click');
        <?php unset($_SESSION['dont_close_alert']);
        }
        ?>
    </script>
    <!-- DataTables -->
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
    <script>
        $(function() {
            $("#example1").DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    
                ],
                "bPaginate": false,
                "bInfo": false,
                "paging": false,
                
                });
            
        });
    </script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>