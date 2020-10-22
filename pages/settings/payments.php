<?php
session_start();
include 'process.php';

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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <?php
                        if (isset($_SESSION['error'])){ ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $_SESSION['error'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['error']); }
                        elseif (isset($_SESSION['success'])){ ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $_SESSION['success'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['success']); }
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item active">Payment types</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <?php if(isset($_GET["payment_edit"]) and !empty($_GET["payment_edit"])) { ?>

                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit a Payment Method</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <div class="card-body">
                                        <span style="color: red;">Sections marked with * must be filled</span>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name: <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="payment_name" placeholder="Enter a name e.g. cash" value="<?php echo $payment_name; ?>">
                                            <span style="color: red;"><?php echo $payment_name_err; ?></span>
                                        </div>

                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <?php if ($update) :?>
                                                <button type="submit" class="btn btn-primary" name="payment_update">Update</button>
                                            <?php else:?>
                                                <button type="submit" class="btn btn-primary" name="payment_submit">Submit</button>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->

                    <?php } else { ?>

                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add a Payment Method</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <div class="card-body">
                                        <span style="color: red;">Sections marked with * must be filled</span>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name: <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="payment_name" placeholder="Enter a name e.g. cash" value="<?php echo $payment_name; ?>">
                                            <span style="color: red;"><?php echo $payment_name_err; ?></span>
                                        </div>

                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <?php if ($update) :?>
                                                <button type="submit" class="btn btn-primary" name="payment_update">Update</button>
                                            <?php else:?>
                                                <button type="submit" class="btn btn-primary" name="payment_submit">Submit</button>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->

                    <?php } ?>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Payment methods</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $number =1;
                                    $res = $conn->query("SELECT * FROM payment_types") or die($conn->error);
                                    while ($row= $res->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td style="width: 40px;"><a href="<?= $_SERVER["PHP_SELF"] ?>?payment_delete=<?php echo $row['id'];?>"><button class="btn btn-danger">Delete</button></a></td>
                                            <td style="width: 40px;"><a href="<?= $_SERVER["PHP_SELF"] ?>?payment_edit=<?php echo $row['id'];?>"><button class="btn btn-secondary">Update</button></a></td>
                                        </tr>
                                        <?php
                                        $number++;
                                    endwhile;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
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
<!-- ./wrapper -->

<!-- scripts -->
<?php include __DIR__.'/../partials/scripts.php'; ?>
<!-- /.scripts -->

</body>
</html>
