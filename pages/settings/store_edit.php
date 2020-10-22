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
              <li class="breadcrumb-item active">Create Store</li>
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
          <div class="col-md-8 offset-md-2">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add a Store</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="card-body">

                  <span style="color: red;">Sections marked with * must be filled</span>
                  <input type="hidden" name="id" value="<?php echo $id; ?>">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Name: <span style="color: red;">*</span></label>
                    <input type="text" required class="form-control" name="store_name" placeholder="Enter a name e.g. Test Store Here" value="<?php echo $store_name; ?>">
                    <span style="color: red;"><?php echo $store_name_err; ?></span>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone No: </label>
                    <input type="text" class="form-control" name="phone" placeholder="Enter a Phone Number" value="<?php echo $phone; ?>">
                    <span style="color: red;"><?php echo $phone_err; ?></span>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Email: </label>
                    <input type="email" class="form-control" name="email" placeholder="Enter an email" value="<?php echo $email; ?>">
                    <span style="color: red;"><?php echo $email_err; ?></span>
                  </div>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-6">

                      <label for="exampleInputEmail1">Vendor:</label>
                      <div class="form-group">
                        
                        <select class="form-control" id="id" name="vendor">

                              <?php 

                                  // if(!isset($_POST['vendor']) or empty($_POST['vendor'])) {

                                  //   echo "<option selected value=''> --- Select Vendor --- </option>"; 

                                  // } else {

                                  //   $vendor = $_POST['vendor'];
                                  //   $supplier = $conn->query("SELECT name, id FROM supplier where id='$vendor'") or die($conn->error);
                                  //   $column = $supplier->fetch_array();
                                  //   echo "<option selected value=".$column['id'].">".$column['name']."</option>";
                                  //   echo "<option value=''> --- Select Vendor --- </option>";

                                  // }
                                ?> 
                          
                                <?php

                                  $stores = $conn->query("SELECT id, name FROM supplier order by name") or die($conn->error);

                                  if(empty($vendor)) {

                                    echo "<option value=''> --- Select Vendor --- </option>";

                                    while ($row=$stores->fetch_assoc()) {
  
                                      echo "<option value=".$row['id'].">".$row['name']."</option>";
                                                                          
                                    }

                                  } else {

                                    echo "<option value=''> --- Select Vendor --- </option>"; 

                                    while ($row=$stores->fetch_assoc()) {
  
                                      if($row["id"] == $vendor) {
  
                                        echo "<option selected value=".$row['id'].">".$row['name']."</option>";
  
                                      } else {
  
                                        echo "<option value=".$row['id'].">".$row['name']."</option>";
  
                                      }
  
                                                                          
                                    }

                                  }



                                ?>
                        </select>

                      </div>

                      </div>
                      <div class="col-md-6">

                        <div class="form-group">
                          <label for="exampleInputEmail1">Code: <span style="color: red;">*</span></label>
                          <input required type="text" class="form-control" name="code" placeholder="Enter a Code e.g TSH" value="<?php echo $code; ?>">
                          <span style="color: red;"><?php echo $code_err; ?></span>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Address:</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter an Address" value="<?php echo $address; ?>">
                    <span style="color: red;"><?php echo $address_err; ?></span>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Web: </label>
                    <input type="text" class="form-control" name="web" placeholder="Enter Web" value="<?php echo $web; ?>">
                    <span style="color: red;"><?php echo $web_err; ?></span>
                  </div>

                  <div class="form-group" id="costofshells">
                    <input type="checkbox" name="is_mobile" value=""> &nbsp;Is a mobile store
                  </div>

                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="stores_update">Update</button>
                </div>
              </div>
            </form>
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
<!-- ./wrapper -->

<!-- scripts -->
<?php include __DIR__.'/../partials/scripts.php'; ?>
<!-- /.scripts -->

</body>
</html>
