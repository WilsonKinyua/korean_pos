<?php 

include '../utils/conn.php';
include 'process.php';
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-1">
           
            <a href="users_create.php" class="btn btn-primary btn-lg">Add User</a>
          </div>
          <div class="col-md-11">
          &nbsp;
          </div>
        </div>
               <div class="row">
                 <div class="col-md-12 m-2">
                 <table id="" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Role</th>
                      <th>Phone</th>
                      <th>User Id</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $users = $conn->query("SELECT users.id as user_id,users.userId as userId, users.name, users.username, users.mobile, security_groups.group_name FROM users INNER JOIN security_groups ON users.user_group=security_groups.id ") or die($conn->error);
                      while ($row=$users->fetch_assoc()) :
                     ?>
                     <tr>
                       <td><?php echo $row['username']; ?></td>
                       <td><?php echo $row['name']; ?></td>
                       <td><?php echo $row['group_name']; ?></td>
                       <td><?php echo $row['mobile']; ?></td>
                       <td><?php echo isset($row['userId']) ? $row['userId'] : ''; ?></td>
                      <td>
                        <a href="users.php?user_delete=<?php echo $row['user_id']; ?>" class="btn m-2 btn-xs btn-danger delete_user_button"><i class="fas fa-trash-alt"></i> Delete</button>
                        <a href="user_update.php?user=<?php echo $row['user_id']; ?>" class="btn m-2 btn-xs btn-secondary"><i class="fas fa-pen-alt"></i>Update</button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                  </tbody>
                </table>
                 </div>
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
