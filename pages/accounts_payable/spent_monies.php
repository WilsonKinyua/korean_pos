<?php
session_start();
include 'spent-process.php';
$message = "";


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


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show <?= isset($_SESSION['dont_close_alert']) ? 'dont-close' : '' ?>" role="alert">
                                    <?= $_SESSION['error'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php unset($_SESSION['error']);
                            }
                            if (isset($_SESSION['success'])) { ?>
                                <div class="alert alert-success alert-dismissible fade show <?= isset($_SESSION['dont_close_alert']) ? 'dont-close' : '' ?>" role="alert">
                                    <?= $_SESSION['success'] ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php unset($_SESSION['success']);
                            }
                            ?>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Pay Supplier</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="spent_monies.php" method="POST">
                                    <input type="hidden" name="salesman" value="<?php echo $username; ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <?php
                                                $query = $conn->query('SELECT id FROM spent_moneys ORDER BY id DESC LIMIT 1');
                                                $last = $query->fetch_assoc();
                                                $lastId = isset($last['id']) ? (int)$last['id'] : 0;
                                                $docId = str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
                                                ?>
                                                <div class="col-md-4 form-group">
                                                    <label>Receipt Number: </label>
                                                    <input type="text" name="doc_number" value="RM-<?php echo $docId; ?>" class="form-control" readonly>
                                                    <span style="color: red;"><?php echo $doc_err; ?></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="">Supplier: </label>
                                                    <select class="form-control" name="supplier_name" id="supplier" onchange="pickCost()"> <?php
                                                                                                                                            if (isset($_POST['supplier_name'])) {
                                                                                                                                                $supplier_name = $_POST['supplier_name'];
                                                                                                                                                $supplier = $conn->query("SELECT id,name FROM supplier WHERE id = '$supplier_name'") or die($conn->error);
                                                                                                                                                $result = $supplier->fetch_array();
                                                                                                                                                echo "<option selected value=" . $row['id'] . "> " . $row['name'] . "</option>";
                                                                                                                                            } else {
                                                                                                                                                echo "<option value='' disabled selected>--Select Supplier--</option>";
                                                                                                                                                $query = $conn->query("SELECT id,name FROM supplier");
                                                                                                                                                while ($row = mysqli_fetch_assoc($query)) {
                                                                                                                                                    echo  "<option value=" . $row['id'] . "> " . $row['name'] . "</option>";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>
                                                    </select>
                                                    <span style="color:red;"><?php echo $cust_err; ?></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="">Account From: </label>
                                                    <select class="form-control" name="account_id">
                                                        <option value="">Select an option</option>
                                                        <?php
                                                        $res = $conn->query("SELECT id, name FROM coa  ORDER BY name ASC") or die($conn->error);
                                                        while ($row = $res->fetch_assoc()) { ?>
                                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                        <?php }
                                                        ?>
                                                        ?>
                                                    </select>
                                                    <span style="color: red;"><?php echo $acc_err; ?></span>
                                                </div>
                                                <div class="col-md-12">
                                                    <?php echo $message; ?>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="">Payment Type: </label>
                                                    <select class="form-control" name="payment_type">
                                                        <option value="">Select an option</option>
                                                        <?php
                                                        $py = $conn->query('SELECT * FROM `payment_types`') or die($conn->error);
                                                        while ($row = $py->fetch_assoc()) { ?>
                                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <span style="color: red;"><?php echo $type_err; ?></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="">Amount: </label>
                                                    <input type="number" min="1" name="amount" class="form-control">
                                                    <span style="color: red;"><?php echo $amt_err; ?></span>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Receipt Date: </label>
                                                    <input type="date" name="sale_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tax_rate">Tax : </span></label>
                                                    <select class="form-control" name="tax_rate" required>
                                                        <?php
                                                        $res1 = $conn->query("SELECT id, tax_rate, name FROM tax_rates") or die($conn->error);
                                                        while ($str = $res1->fetch_assoc()) {
                                                            $id = 1;
                                                            if ($str['id'] == $id) {
                                                                echo  "<option value='" . $str['tax_rate'] . "' selected> " . $str['name'] . "</option>";
                                                            } else {

                                                                echo "<option value='" . $str['tax_rate'] . "'> " . $str['name'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tax_in_ex">Tax Inclusive/exclusive: </span></label>
                                                    <select class="form-control" name="tax_in_ex" required>
                                                        <option value="inclusive">Inclusive</option>
                                                        <option value="exclusive">Exclusive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Description</label>
                                                    <textarea name="description" placeholder="Invoice description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="submit" name="save" class="btn btn-primary" style="margin-left: 2em;">Save</button>
                                            <button type="submit" name="save_print" class="btn btn-primary mr-2" style="margin-left: 2em;">Save & Print</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- /.card-body -->
                            </div>
                            </form>
                            <?php
                            if (isset($_SESSION['dont_close_alert'])) { ?>
                                <button hidden id="print" onclick="window.open('spent_print.php?payment_id=<?= $_SESSION['dont_close_alert'] ?>', '_blank');"></button>
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

    <?php
    include __DIR__ . '/../partials/footer.php';
    ?>
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
                    window.location.href = "invoice_create.php?page=products&action=add&name=" + name;
                }
            });

        });
        $(function() {
            var current = location.pathname.replace(/\/[A-Z1-9-+]+\/[A-Z1-9-+]+\//i, '../');
            console.log(current)
            $('.nav li a').each(function() {
                var $this = $(this);
                // if the current path is like this link, make it active
                if ($this.attr('href').indexOf(current) !== -1) {
                    $this.addClass('active');
                    $this.parents('.nav-treeview').prev().addClass('active').parent().addClass('menu-open');
                }
            })
        })

        let total = 0
        $('input.select-invoice').on('click', function(e) {
            if ($(this).is(':checked')) {
                total += parseFloat($(this).data('amount'))
                if ($('input.select-invoice').length == $('input.select-invoice:checked').length) {
                    $('.select-all#all').prop('checked', true)
                }
            } else {
                total -= parseFloat($(this).data('amount'))
                if ($('.select-all#all').is(':checked')) {
                    $('.select-all#all').prop('checked', false)
                }
            }
            $('.invoice-total').val(total.toFixed(2));
        });

        $('.select-all#all').click(function(e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);

            if ($(this).is(':checked')) {
                total = 0;
                $('input.select-invoice').each(function() {
                    total += parseFloat($(this).data('amount'))
                })
            } else {
                total = 0
            }

            $('.invoice-total').val(total.toFixed(2));
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
        $('form').on('submit', function(e) {
            // e.preventDefault();
            //
            // console.log($(this).serializeArray())
        })
    </script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>