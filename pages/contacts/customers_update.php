<?php include 'process.php'; ?>
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
    <!--<div class="content-header">-->
    <!--  <div class="container-fluid">-->
    <!--    <div class="row mb-2">-->
    <!--      <div class="col-sm-6">-->
    <!--        <h1 class="m-0 text-dark">Dashboard</h1>-->
    <!--      </div><!-- /.col -->
    <!--      <div class="col-sm-6">-->
    <!--        <ol class="breadcrumb float-sm-right">-->
    <!--          <li class="breadcrumb-item"><a href="#">Home</a></li>-->
    <!--          <li class="breadcrumb-item active">Dashboard v1</li>-->
    <!--        </ol>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> Update Customer </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="card-body">
                  <span style="color: red;">Sections marked with * must be filled </span>
                  <input type="hidden" name="id" value="<?php echo $customer_row['id']; ?>">
                  <div class="row">
                      <div class="col-md-4">
                        <label for="">Name : <span style="color: red;">*</span></label>
                        <input type="text" name="name" value="<?php echo $customer_row['cust_name'] ?>" placeholder="Business name" class="form-control">
                      </div>
                    <div class="col-md-4">
                      <label for="">Contact: <span style="color: red;">*</span></label>
                      <input type="text" value="<?php echo $customer_row['cust_contact'] ?>" name="contact" placeholder="Mobile Phone"  class="form-control" required>
                    </div>
                    <div class="col-md-4">
                      <label for="">KRA PIN: </label>
                      <input type="text" maxlength="15" name="refno" value="<?php echo $customer_row['kra_pin'] ?>" class="form-control" placeholder="KRA PIN" />
                    </div>
                    <div class="col-md-4">
                      <label for="">Contact Code: </label>
                      <input type="text" value="<?php echo $customer_row['code'] ?>" name="code" class="form-control" placeholder="Code: eg C025-202905" />
                    </div>
                    <hr>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="">Opening Balance: </label>
                      <input type="text" name="opening_balance" value="<?php echo $customer_row['total_paid'] ?>" class="form-control" />
                    </div>
                    <div class="col-md-4">
                      <label for="">Pay Term: </label>
                      <!-- <input type="text" class="form-control" name="payterm" value="<?php echo $customer_row['pay_term'] ?>" placeholder="No. of days e.g. 30"> -->

                      <select class="form-control" name="payterm">
                        <?php 
                      
                            $res = $conn->query("SELECT * FROM pay_terms") or die($conn->error);

                        ?>

                        <?php 

                          while ($row = $res->fetch_assoc()) {



                            if($row['id'] == $customer_row['pay_term']) {
                              echo "<option selected value=".$row["id"].">".$row['name']."</option>";
                            } else {
                              echo "<option value=".$row["id"].">".$row['name']."</option>";
                            }
  
                          }

                        ?>
                      </select>


                    </div>
                    <div class="col-md-4">
                      <label for="">Customer Group: <span style="color: red;">*</span></label>
                      <select class="form-control" name="group">
                        <?php
                        $res = $conn->query("SELECT id, name FROM cust_groups order by name") or die($conn->error);
                        while ($row = $res->fetch_assoc()) {
                          if($row['id'] == $customer_row['id']) {

                            echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';

                          } else {
                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                          }
                        }
                         ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="">Credit Limit: </label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">Kshs</div>
                          </div>
                          <input type="text" class="form-control" name="credit" value="<?php echo $customer_row['credit_limit'] ?>" placeholder="Credit limit">
                        </div>
                    </div>
                    <div class="col-md-9">
                      <label for="">Shipping Address: </label>
                      <textarea name="address" rows="4" cols="2" class="form-control"> <?php echo $customer_row['shipping_address'] ?> </textarea>
                    </div>
                    <div class="col-md-4"></div>
                    <hr>
                  </div>
                  <hr>

                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="customer_update">Update</button>
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
<!--    footer-->
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
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
 <script>
     $(function(){
         var current = '../contacts/customers.php';
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
