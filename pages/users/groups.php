<?php include '../utils/conn.php';
session_start();
if (!isset($_SESSION['group'])) {
  header('location: ../utils/logout.php');
}else{
  $username = $_SESSION['userId'];
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
    <div class="content-header">
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-11">
          &nbsp;
        </div>
        <div class="col-md-1">
          <a href="groups_create.php" class="btn btn-primary">Add</a>
        </div>
      </div>
      <div class="row">
        &nbsp;
      </div>
      <div class="container-fluid">
        <?php
        $res = $conn->query("SELECT * FROM security_groups") or die($conn->error);
        while ($row=$res->fetch_assoc()) { ?>
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><?php echo $row['group_name']; ?></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                 <!-- checkbox -->
                  <div class="form-group">
                    <label>Inventory</label>
                    <?php if ($row['manage_categories']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_categories" checked><label>Manage Categories</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_categories"><label>Manage Categories</label>
                    </div>
                    <?php } if ($row['manage_products']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_products" checked><label>Manage Products</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_products"><label>Manage Products</label>
                    </div>
                    <?php } if ($row['manage_suppliers']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_suppliers" checked><label>Manage Suppliers</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_suppliers"><label>Manage Suppliers</label>
                    </div>
                  <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                 <!-- checkbox -->
                  <div class="form-group">
                    <label>Stocks</label>
                    <?php if ($row['receive_stock']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="receive_stock" checked><label>Receive Stock</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="receive_stock"><label>Receive Stock</label>
                    </div>
                    <?php } if ($row['transfer_stock']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="transfer_stock" checked><label>Transfer Stock</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="transfer_stock"><label>Transfer Stock</label>
                    </div>
                    <?php } if ($row['issue_stock']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="issue_stock" checked><label>Issue Stock</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="issue_stock"><label>Issue Stock</label>
                    </div>
                    <?php } if ($row['request_stock']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="request_stock" checked><label>Request Stock</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="request_stock"><label>Request Stock</label>
                    </div>
                  <?php } ?>
                  </div>
                </div>
                <div class="col-md-3">
                 <!-- checkbox -->
                  <div class="form-group">
                    <label>Sales</label>
                    <?php if ($row['make_sales']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="make_sales" checked><label>Make Sales</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="make_sales"><label>Make Sales</label>
                    </div>
                    <?php } if ($row['clear_sales']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="clear_sales" checked><label>Clear Sales</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="clear_sales"><label>Clear Sales</label>
                    </div>
                    <?php } if ($row['credit_sales']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="credit_sales" checked><label>Make Credit Sale</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="credit_sales"><label>Make Credit Sale</label>
                    </div>
                  <?php } ?>
                  </div>
                </div>

               
                <div class="col-md-3">
                 <!-- checkbox -->
                  <div class="form-group">
                    <label>Security</label>
                    <?php if ($row['manage_users']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_users" checked><label>Manage Users</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_users"><label>Manage Users</label>
                    </div>
                    <?php } if ($row['manage_user_groups']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_user_groups" checked><label>Manage User Groups</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_user_groups"><label>Manage User Groups</label>
                    </div>
                    <?php } if ($row['manage_user_rights']==1) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_user_rights" checked><label>Manage User Rights</label>
                    </div>
                    <?php } else { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="manage_user_rights"><label>Manage User Rights</label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer" style="display: none;">
              <a href="groups_create.php?group_edit=<?php echo $row['id']; ?>"><button type="submit" class="btn btn-primary" name="user_groups_submit">Edit User Rights</button></a>
            </div>
        </div>
      <?php } ?>
      

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <?php
    include __DIR__.'/../partials/footer.php';
    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

<?php
include __DIR__.'/../partials/scripts.php';
?>

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Page specific script -->
<script type="text/javascript">
$(function () {
  $("#example1").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});
</script>
  </body>
  </html>
