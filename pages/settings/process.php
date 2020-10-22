<?php
// $conn = mysqli_connect('localhost','root','','premierdb') or die($conn->error);
include '../utils/conn.php';
$update = false;

$name = "";
$rate = "";
$option = "";
$payment_name = "";

$rate_err = $tax_name_err = $payment_name_err = "";
$valid = true;

if (isset($_POST['taxes_submit'])) {
	$name = $_POST['name'];
  $rate = $_POST['rate'];
	if (empty($name)) {
		$tax_name_err = "Name is required";
		$valid = false;
	}
  if (!is_numeric($rate)) {
		$rate_err = "Rate is required";
		$valid = false;
	}
	if ($valid) {
		$conn->query("INSERT INTO `tax_rates`(`name`, `tax_rate`) VALUES ('$name','$rate')") or die($conn->error);

		header('location: tax_rates.php');
	}


}
if (isset($_GET['taxes_edit'])) {
	$id = $_GET['taxes_edit'];
	$res = $conn->query("SELECT * FROM tax_rates WHERE id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
        $name = $row['name'];
        $update=true;
        $rate = $row['tax_rate'];
    }
}
if (isset($_GET['taxes_delete'])) {
	$id = $_GET['taxes_delete'];
	$conn->query("DELETE FROM tax_rates WHERE id='$id'") or die($conn->error);

	header('location: tax_rates.php');
}
if (isset($_POST['taxes_update'])) {

	$id = $_POST['id'];
	$name = $_POST['name'];
	$rate = $_POST['rate'];
	  
	if (empty($name)) {
		$tax_name_err = "Name is required";
		$valid = false;
	}
	if (empty($rate)) {
			$rate_err = "Rate is required";
			$valid = false;
	}

	if ($valid) {

		$conn->query("UPDATE `tax_rates` SET `name`='$name',`tax_rate`='$rate' WHERE id='$id'") or die($conn->error);
		header('location: tax_rates.php');

	} else {
		header("location: tax_rates.php?taxes_edit=$id");
	}

}
// End of Taxes processes

$discount_name_err = $discount_rate_err = "";
$valid = true;

if (isset($_POST['discount_submit'])) {
	$name = $_POST['name'];
  $rate = $_POST['rate'];
	if (empty($name)) {
		$tax_name_err = "Name is required";
		$valid = false;
	}
  if (empty($rate)) {
		$rate_err = "Rate is required";
		$valid = false;
	}
	if ($valid) {
		$conn->query("INSERT INTO `discounts`(`name`, `discount_rate`) VALUES ('$name','$rate')") or die($conn->error);

		header('location: discounts.php');
	}


}
if (isset($_GET['discounts_edit'])) {
	$id = $_GET['discounts_edit'];
	$res = $conn->query("SELECT * FROM discounts WHERE id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
        $name = $row['name'];
        $update=true;
        $rate = $row['discount_rate'];
    }
}
if (isset($_GET['discounts_delete'])) {
	$id = $_GET['discounts_delete'];
	$conn->query("DELETE FROM discounts WHERE id='$id'") or die($conn->error);

	header('location: discounts.php');
}
if (isset($_POST['discount_update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
  $rate = $_POST['rate'];
	$conn->query("UPDATE `discounts` SET `name`='$name',`discount_rate`='$rate' WHERE id='$id'") or die($conn->error);

	header('location: discounts.php');
}

// Pay Terms
$term_name = $pay_terms = "";
$term_name_err = $term_err = "";
$valid = true;
if (isset($_POST['terms_submit'])) {
	$term_name = trim($_POST['term_name']);
	$pay_terms = trim($_POST['pay_terms']);

	if (empty($term_name)) {
		$term_name_err = "Name is required";
		$valid = false;
	}
	if(!is_numeric($pay_terms)){
		$term_err = "Invalid input. Number is required";
		$valid = false;
	}
	if ($valid) {
		$sql = $conn->query("INSERT INTO pay_terms (`name`,`pay_terms`) VALUES ('$term_name','$pay_terms')") or die($conn->error);
		if ($sql) {
			header('location: pay_terms.php');
		}
	}
}

if (isset($_GET['pay_term_delete'])) {
	$id = $_GET['pay_term_delete'];
	$conn->query("DELETE FROM `pay_terms` WHERE id='$id'") or die($conn->error);

	$_SESSION['success'] = 'Pay Term deleted';

	header('location: pay_terms.php');
	exit();
}

if (isset($_GET['pay_term_edit'])) {

	$id = $_GET['pay_term_edit'];
	$res = $conn->query("SELECT * FROM pay_terms WHERE id='$id'") or die($conn->error);

	if (mysqli_num_rows($res) == 1){

        $row = $res->fetch_array();
		$term_name = $row['name'];
		$pay_terms=$row["pay_terms"];
		$id=$row["id"];
		$update=true;
		
	}
	
}

if (isset($_POST['pay_term_update'])) {

	$term_name = trim($_POST['term_name']);
	$pay_terms = trim($_POST['pay_terms']);
	$id=$_POST["id"];

	if (empty($term_name)) {
		$term_name_err = "Name is required";
		$valid = false;
	}
	if(!is_numeric($pay_terms)){
		$term_err = "Invalid input. Number is required";
		$valid = false;
	}
	if ($valid) {
		// $sql = $conn->query("INSERT INTO pay_terms (`name`,`pay_terms`) VALUES ('$term_name','$pay_terms')") or die($conn->error);
		$sql = $conn->query("UPDATE `pay_terms` SET `name`='$term_name', `pay_terms`='$pay_terms' WHERE id='$id'") or die($conn->error);

		if ($sql) {
			header('location: pay_terms.php');
		}
	} else {
		$update=true;
		header("location: pay_terms.php?pay_term_edit=$id");

	}
}

// stores
$store_name = $store_name_err = $phone = $phone_err = $email = $email_err = $vendor = $vendor_err = $code = $code_err = $address = $address_err = $web = $web_err = "";
$is_mobile = 0;
$valid = true;

if (isset($_POST['stores_submit'])) {

	$store_name = $_POST['store_name'];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$vendor = $_POST["vendor"];
	$code = $_POST["code"];
	$address = $_POST["address"];
	$web = $_POST["web"];

	if (empty($store_name)) {
		$store_name_err = "Name is required";
		$valid = false;
	}

	if (!empty($phone)) {

		if(strlen($phone) < 10) {

			$phone_err = "Phone Number is Invalid";
			$valid = false;

		}

	}

	// if (empty($email)) {
	// 	$email_err = "Email is required";
	// 	$valid = false;
	// }

	// if (empty($vendor)) {
	// 	$vendor_err = "Vendor is required";
	// 	$valid = false;
	// }

	if (empty($code)) {
		$code_err = "Code is required";
		$valid = false;
	}

	if(!empty($_POST['is_mobile'])){ $is_mobile =1; }

	if ($valid) {
		$conn->query("INSERT INTO `stores`(`name`, `is_mobile`, `vendor`, `address`, `phone`, `email`, `web`, `code`) VALUES ('$store_name','$is_mobile', '$vendor', '$address', '$phone', '$email', '$web', '$code')") or die($conn->error);
		setcookie("message", "Store Created Successfully", time()+3);
		header('location: stores.php');
	}

}

if (isset($_GET['store_delete'])) {

	$id = $_GET['store_delete'];
	$conn->query("DELETE FROM `stores` WHERE id='$id'") or die($conn->error);

	setcookie("message", "Store Deleted Successfully", time()+3);

	header('location: stores.php');
	exit();

}

if (isset($_GET['store_edit'])) {

	$id = $_GET['store_edit'];
	$res = $conn->query("SELECT * FROM stores WHERE id='$id'") or die($conn->error);

	if (mysqli_num_rows($res) == 1){

		$row = $res->fetch_array();
		
		$store_name = $row['name'];
		$is_mobile = $row['is_mobile'];
		$vendor = $row['vendor'];
		$address = $row['address'];
		$phone = $row['phone'];
		$email = $row['email'];
		$web = $row['web'];
		$code = $row['code'];

		$id=$row["id"];

		$update=true;
		
    }
} 
// else {
// 	header('location: stores.php');
// }

if (isset($_POST['stores_update'])) {

	$store_name = $_POST['store_name'];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$vendor = $_POST["vendor"];
	$code = $_POST["code"];
	$address = $_POST["address"];
	$web = $_POST["web"];
	$id=$_POST["id"];

	if (empty($store_name)) {
		$store_name_err = "Name is required";
		$valid = false;
	}

	if (!empty($phone)) {

		if(strlen($phone) < 10) {

			$phone_err = "Phone Number is Invalid";
			$valid = false;

		}

	}

	// if (empty($email)) {
	// 	$email_err = "Email is required";
	// 	$valid = false;
	// }

	// if (empty($vendor)) {
	// 	$vendor_err = "Vendor is required";
	// 	$valid = false;
	// }

	if (empty($code)) {
		$code_err = "Vendor is required";
		$valid = false;
	}

	if(!empty($_POST['is_mobile'])){ $is_mobile =1; }

	if ($valid) {

		$conn->query(
			"UPDATE `stores` 
				SET `name`='$store_name', 
				`is_mobile`= '$is_mobile', 
				`vendor`= '$vendor', 
				`address` = '$address', 
				`phone`= '$phone', 
				`email`= '$email', 
				`web`= '$web', 
				`code`='$code' 
				WHERE id='$id'
			") or die($conn->error);
		setcookie("message", "Store Updated Successfully", time()+3);
		header('location: stores.php');

	}

}

if (isset($_POST['payment_submit'])) {

	$payment_name = $_POST['payment_name'];
	if (empty($payment_name)) {
		$payment_name_err = "Name is required";
		$valid = false;
	}

	if ($valid) {
		$conn->query("INSERT INTO `payment_types`(`name`) VALUES ('$payment_name')") or die($conn->error);
		$_SESSION['success'] = 'Payment method was created';

		header('location: payments.php');
		exit();
	}

}

if (isset($_GET['payment_edit'])) {
	$id = $_GET['payment_edit'];
	$res = $conn->query("SELECT * FROM payment_types WHERE id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
		$payment_name = $row['name'];
		$id=$row["id"];
        $update=true;
    }
}

if (isset($_POST['payment_update'])) {

	$payment_name = $_POST['payment_name'];

	if (empty($payment_name)) {
		$payment_name_err = "Name is required";
		$valid = false;
	}

	if ($valid) {

		$id=$_POST["id"];
		$conn->query("UPDATE `payment_types` SET `name`='$payment_name' WHERE id='$id'") or die($conn->error);
		$_SESSION['success'] = 'Payment method Updated';

		header('location: payments.php');
		exit();
	}

}

if (isset($_GET['payment_delete'])) {
	$id = $_GET['payment_delete'];
	$conn->query("DELETE FROM `payment_types` WHERE id='$id'") or die($conn->error);

	$_SESSION['success'] = 'Payment method was deleted';

	header('location: payments.php');
	exit();
}
?>
