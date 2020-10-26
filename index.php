<?php
include 'pages/utils/conn.php';
session_start();
if (!isset($_SESSION['group'])) {
  header('location: pages/utils/logout.php');
}else{
  $username = $_SESSION['userId'];
  $group = $_SESSION['group'];
}

 ?>
 <!DOCTYPE  html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Korean Kenya Solar</title>
  <!-- <link rel="icon" type="image/x-icon" href="dist/img/favicon.ico"> -->
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pages/pos/">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <!-- <img src="dist/img/favicon.ico" alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Korean Kenya Solar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Korean Kenya Solar</a>
        </div>
      </div>
      <?php
         // $conn = mysqli_connect("localhost",'root','','premierdb')or die($conn->error);
         $rights = $conn->query("SELECT * FROM security_groups WHERE id='$group' ")or die($conn->error);
         if (mysqli_num_rows($rights) == 1) {
           $row = $rights->fetch_array();
           $group = $row["group_name"];
      ?><!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php 
          
          if(!($row["view_dashboard"] == 0)) { ?>
            <li class="nav-item has-treeview">
             <a href="index.php" class="nav-link active">
               <i class="nav-icon fas fa-tachometer-alt"></i>
               <p>
                 Dashboard
               </p>
             </a>
           </li>
         <?php }
         
         if (!($row["manage_users"] == 0 && $row["manage_user_groups"] == 0)) {?>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php 
            
            if (!($row["manage_users"] == 0)) { ?>
              <li class="nav-item">
                <a href="pages/users/users.php" class="nav-link">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
            <?php } 
            
            if (!($row["manage_user_groups"] == 0)) { ?>
              <li class="nav-item">
                <a href="pages/users/groups.php" class="nav-link">
                  <i class="fas fa-briefcase nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
            <?php } ?>
            </ul>
          </li>
        <?php } 
        
        if (!($row["manage_suppliers"] == 0 && $row["manage_customers"] == 0 && $row["manage_customer_groups"] == 0)) {?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Contacts
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if (!($row["manage_suppliers"] == 0)){ ?>
              <li class="nav-item">
                <a href="pages/contacts/suppliers.php" class="nav-link">
                  <i class="fas fa-truck-loading nav-icon"></i>
                  <p>Suppliers</p>
                </a>
              </li>
            <?php } if (!($row["manage_customers"] == 0)){ ?>
              <li class="nav-item">
                <a href="pages/contacts/customers.php" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
            <?php } if (!($row["manage_customer_groups"] == 0)){ ?>
              <?php }?>
            </ul>
          </li>
        <?php }
        
        if (!($row["manage_products"] == 0 && $row["manage_categories"] == 0)) {?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if (!($row["manage_products"] == 0)){?>
              <li class="nav-item">
                <a href="pages/products/list.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Products List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/products/products_create.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Products</p>
                </a>
              </li>
			  <?php } if (!($row["manage_price_rules"] == 0)){ ?>

            <?php } if (!($row["manage_categories"] == 0)){ ?>
              <li class="nav-item">
                <a href="pages/products/categories.php" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Product Categories</p>
                </a>
              </li>
            <?php } ?>
            </ul>
          </li>
        <?php }
        
        if (!($row["receive_stock"] == 0)){?>
        <?php }
        
        if (!($row["make_sales"] == 0)) {?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                 Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview"> 
              <?php if (!($row["make_sales"] == 0)){ ?>
              <li class="nav-item">
                <a href="pages/sales/sales_create.php" class="nav-link">
                  <i class="fas fa-shipping-fast nav-icon"></i>
                  <p>Create Sales</p>
                </a>
              </li>
              <?php if (!($row["manage_categories"] == 0)){ ?>
              <li class="nav-item">
                <a href="pages/sales/sales_list.php" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>List Sales</p>
                </a>
              </li>
            <?php } } if (!($row["clear_sales"] == 0)){ ?>
            <?php } if (!($row["clear_sales"] == 0)){ ?>
            <?php } ?>
            </ul>
          </li>
	         <?php if (!($row["adjust_stock"] == 0)){ ?>
		<?php } } ?>      
		 <?php  if (!($row["settings"] == 0)){?>
      
		 <?php }  ?>
        
        <!--************* REPORTS Side Nav ************************* -->

		 <?php }   ?>
            
 <!--*******************************************************************  -->
        
        <li class="nav-item">
          <a href="pages/utils/logout.php" class="nav-link">
            <i class="nav-icon fas fa-undo-alt"></i>
            <p>Logout</p>
          </a>
        </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
        <section class="content">
          <div class="container-fluid">

          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#">Korean Kenya Solar</a>.</strong> All rights reserved.

     
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  </body>
  </html>