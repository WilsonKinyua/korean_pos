<?php

  include 'process.php';

?>
<?php
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Settings</a></li>
              <li class="breadcrumb-item active">Tax Rates</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <?php if(isset($_COOKIE['message']) and $_COOKIE['message']) {?>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 text-center">
                    <div id="notif" class="alert alert-success text-center alert-dismissible fade show mt-4" role="alert">
                        <strong> <?php echo $_COOKIE['message'] ?> </strong>
                        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

    <script>
        setTimeout(function() {
            let alerter = document.getElementById('notif')
            if(alerter) {
                alerter.parentNode.removeChild(alerter);
            }
        }, 3000)

    </script>

<!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12 pb-3">
            <a href="store_create.php" styles="width: 100px;" class="btn btn-success float-right">Add</a>
          </div>
        </div>

        <div class="row">

            <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Stores</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Store Type</th>
                      <th>Vendor</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Code</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $number =1;
                    $res = $conn->query(
                      "SELECT 
                        stores.name, 
                        stores.id, 
                        stores.is_mobile, 
                        stores.vendor, 
                        stores.address, 
                        stores.phone, 
                        stores.email, 
                        stores.web, 
                        stores.code, 
                        supplier.name as vendor_name 
                        FROM stores LEFT JOIN supplier ON supplier.id=stores.vendor"
                    ) or die($conn->error);
                    while ($row= $res->fetch_assoc()):
                    ?>
                    <tr>
                      <td><?php echo $number; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      
                      <?php if($row['is_mobile']== 1) {
                        echo "<td>Mobile Store</td>";
                      }else {
                        echo "<td>Warehouse</td>";
                      }
                      ?>
                      <td><?php echo $row['vendor_name']; ?></td>
                      <td><?php echo $row['address']; ?></td>
                      <td><?php echo $row['phone']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['code']; ?></td>
                      <td>
                        <a styles="width: 100%; !important" href="stores.php?store_delete=<?php echo $row["id"] ?>" class="btn btn-sm btn-danger">Delete</a>
                      </td>
                      <td>
                        <a styles="width: 100%; !important" href="store_edit.php?store_edit=<?php echo $row["id"] ?>" class="btn btn-sm btn-secondary">Update</a>
                      </td>
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
