<?php
// $conn = mysqli_connect('localhost','root','','premierdb') or die($conn->error);
include 'conn.php';
$user_id = $pass_err = "";
$valid = true;
if (isset($_POST['sign_in'])) {


	if (empty($_POST['userId'])) {

		$user_id = "Enter your userId";
    $valid = false;
    
	}else{

		$userId = trim($_POST['userId']);
  }
  
	if (empty($_POST['password'])) {

		$pass_err = "Enter your password";
    $valid = false;
    
	}else{

    $password = trim($_POST['password']);
    
	}

	$res = $conn->query("SELECT * FROM users WHERE username='$userId' ") or die($conn->error);
	if (mysqli_num_rows($res) == 1) {
		$row = $res->fetch_assoc();
    $hashed_password = $row['password'];
    
		if (md5($password) == $hashed_password) {

			session_start();
      $_SESSION['userId'] = $userId;
      $_SESSION['name'] = $name;
			$_SESSION['group'] = $row['user_group'];
			$_SESSION['userId'] = $row['id'];
      header('location: ../../index.php');
      
		}else{

      $pass_err = "Incorrect Password";
      
		}
	}else{

    $user_id = "userId not found";
    
	}

}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Korean Kenya Solar | Log in</title>
  <!-- <link rel="icon" type="image/x-icon" href="../../dist/img/favicon.ico"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="
        background-image:url('https://cdn.pixabay.com/photo/2017/11/11/17/05/solar-system-2939551_960_720.jpg');
        background-repeat: no-repeat;
      background-size: cover;
">
<div class="login-box">
  <!-- /.login-logo -->

  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="login.php" class="h1"><b>Korean Kenya </b> Solar</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to access your account</p>
    
      <form method="post" id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Enter username" name="userId" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <span style="color: red;"><?php echo $user_id; ?></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Enter Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <span style="color: red;"><?php echo $pass_err; ?></span>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember_me">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="sign_in">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="home/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="home/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="home/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="home/plugins/jquery-validation/additional-methods.min.js"></script>

<script>
$(function () {
    
  $('#loginForm').validate({
    rules: {
      userId: {
        required: true,
        userId: true,
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      userId: {
        required: "Please enter a userId",
        userId: "Please enter a vaild userId "
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
    //   terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>

</body></html>
