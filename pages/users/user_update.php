<?php include 'process.php';
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
    <div class="content-header">
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	<div class="row">
      		<div class="col-md-12">
      			<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">UPDATE USER</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                	<div class="row">
                		<div class="col-md-4">
	                		<div class="form-group">
		                		<label>Name</label>
		                		<input type="text" name="name" value="<?php echo $row_user_update['name'] ?>" class="form-control" placeholder="Enter a name e.g. Raymond">
                        <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["name_err"]) ? $_SESSION["user_update_errors"]["name_err"] : ''; ?></span>
	                		</div>
	                	</div>
                		<div class="col-md-4">
	                		<div class="form-group">
		                		<label>ID Number: </label>
		                		<input type="text" name="id_no" value="<?php echo $row_user_update['national_id'] ?>" class="form-control" placeholder="Enter a ID Number e.g. 2381803">
                        <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["id_err"]) ? $_SESSION["user_update_errors"]["id_err"] : ''; ?></span>
	                		</div>
	                	</div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Mobile: </label>
                        <input type="text" name="mobile" value="<?php echo $row_user_update['mobile'] ?>" class="form-control" placeholder="Enter a phone number.g. 0726851900">
                        <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["mobile_err"]) ? $_SESSION["user_update_errors"]["mobile_err"] : ''; ?></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input type="email" value="<?php echo $row_user_update['email'] ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email">
                          <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["email_err"]) ? $_SESSION["user_update_errors"]["email_err"] : ''; ?></span>
                        </div>
                    </div>
	                	<div class="col-md-4">
	                		<div class="form-group">
		                		<label>KRA PIN: </label>
		                		<input type="text" name="kra" value="<?php echo $row_user_update['kra_pin'] ?>" class="form-control" placeholder="Enter a KRA PIN e.g. A0027THF20">
                        <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["kra_err"]) ? $_SESSION["user_update_errors"]["kra_err"] : ''; ?></span>
	                		</div>
	                	</div>

                		<div class="col-md-4">
                			<div class="form-group">
			                    <label for="exampleInputEmail1">Username</label>
			                    <input type="text" value="<?php echo $row_user_update['username'] ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter username e.g. Kylo256#" name="username">
			                  </div>
                        <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["username_err"]) ? $_SESSION["user_update_errors"]["username_err"] : ''; ?></span>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
			                    <label for="exampleInputPassword1">Password</label>
			                    <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="new-password" placeholder="Type To Update Password Else Don't Type" name="password">
                          <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["pass_err"]) ? $_SESSION["user_update_errors"]["pass_err"] : '' ?></span>
			                 </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
			                    <label for="exampleInputPassword1">Confirm Password</label>
			                    <input type="password" class="form-control" id="exampleInputPassword1" autocomplete="new-password" placeholder="Type To Update Password Else Don't Type" name="cpassword">
                          <input type="hidden" value="<?php echo $row_user_update['id'] ?>" class="form-control" name="user_id">
                          <span style="color: red;"><?php echo isset($_SESSION["user_update_errors"]["cpass_err"]) ? $_SESSION["user_update_errors"]["cpass_err"] : ''; ?></span>
			                  </div>
                		</div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <?php $groups = $conn->query("SELECT id, group_name FROM security_groups ") or die($conn->error); ?>
                        <label>User Group</label>
                        <select class="form-control" name="group">

                          <?php
                            while ($row = $groups->fetch_assoc()) {
                              if($row["id"] == $row_user_update['user_group']) {

                                echo "<option selected value=".$row['id'].">".$row['group_name']."</option>";

                              } else {

                                echo "<option value=".$row['id'].">".$row['group_name']."</option>";

                              }
                            }
                           ?>

                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="exampleInputFile">User Passport</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1" name="user_activate">Activate this user</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="user_update_submit">Update</button>
                </div>
              </form>
            </div>
      		</div>
      	</div>
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

  <!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- fullCalendar 2.2.5 -->

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Page specific script -->
<script type="text/javascript">

$(function(){
    var current = '../users/users.php';
    $('.nav li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('active');
            $this.parents('.nav-treeview').prev().addClass('active').parent().addClass('menu-open');
        }
    })
})
</script>
  </body>
  </html>
