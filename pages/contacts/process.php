<?php
require '../utils/conn.php';

$name = $contact = $refno =$email = $opening_balance = $payterm = "";
$update = false;
if (isset($_POST['supplier_submit'])) {
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $refno = $_POST['refno'];
  $opening_balance = $_POST['opening_balance'];
  $payterm = $_POST['payterm'];
  $email = $_POST['email'];

  if($conn->query("INSERT INTO `supplier`(`name`, `kra_pin`, `contact`, `email`, `balance`, `pay_term`) VALUES ('$name','$refno','$contact','$email','$opening_balance','$payterm')") or die($conn->error)){
    header('location: suppliers.php');
  }
}

$supplier_row = null;

// Supplier Get Data For Update
if(isset($_GET['supplier_edit'])) {

  $supplier_id = $_GET['supplier_edit'];

  $supplier = $conn->query("SELECT * from `supplier` WHERE id= '$supplier_id'");

  if (mysqli_num_rows($supplier) == 1) {

		$supplier_row = $supplier->fetch_array();
		
	}
  
}

// Supplier Update
if (isset($_POST['supplier_update'])) {

  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $refno = $_POST['refno'];
  $opening_balance = $_POST['opening_balance'];
  $payterm = $_POST['payterm'];
  $email = $_POST['email'];
  $id = $_POST["id"];

  if($conn->query(

    "UPDATE `supplier` 
      SET `name`='$name', 
      `kra_pin`='$refno', 
      `contact`='$contact', 
      `email`='$email', 
      `balance`='$opening_balance', 
      `pay_term`='$payterm'
      WHERE id='$id'") or die($conn->error)){

    header('location: suppliers.php');

  }

}

// Supplier Delete 
if(isset($_GET['supplier_delete'])) {
  $id = $_GET['supplier_delete'];
  $conn->query("DELETE FROM supplier WHERE id='$id' ") or die($conn->error);
	header('location: suppliers.php');
}


$customer_row = null;

// Supplier Get Data For Update
if(isset($_GET['customer_update'])) {

  $customer_id = $_GET['customer_update'];

  $customer = $conn->query("SELECT * from `customers` WHERE id= '$customer_id'");

  if (mysqli_num_rows($customer) == 1) {

		$customer_row = $customer->fetch_array();
		
	}
  
}

//customers
$name = $contact = $refno = $code =$opening_balance =$payterm = "";
$group = $credit = $address = "";

if (isset($_POST['customer_submit'])) {
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $refno = $_POST['refno'];
  $code = $_POST['code'];
  $opening_balance = $_POST['opening_balance'];
  $payterm = intval($_POST['payterm']);
  $group = $_POST['group'];
  $credit = intval($_POST['credit']);
  $address = $_POST['address'];

  $sql = $conn->query("INSERT INTO `customers`(`cust_name`, `cust_contact`, `kra_pin`, `code`, `pay_term`, `credit_limit`, `cust_group`, `total_owed`, `total_paid`, `shipping_address`) VALUES ('$name','$contact','$refno','$code','$payterm','$credit','$group','$opening_balance','$opening_balance','$address')") or die($conn->error);
  if ($sql) {
    header('location: customers.php');
  }
}

// Customer Update

if (isset($_POST['customer_update'])) {

  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $refno = $_POST['refno'];
  $code = $_POST['code'];
  $opening_balance = $_POST['opening_balance'];
  $payterm = intval($_POST['payterm']);
  $group = $_POST['group'];
  $credit = intval($_POST['credit']);
  $address = $_POST['address'];
  $id = $_POST['id'];

  $sql = $conn->query(
    "UPDATE `customers` 
    SET `cust_name`='$name', 
    `cust_contact`='$contact', 
    `kra_pin`='$refno', 
    `code`='$code', 
    `pay_term`='$payterm', 
    `credit_limit`='$credit', 
    `cust_group`='$group', 
    `total_owed`='$opening_balance', 
    `total_paid`='$opening_balance', 
    `shipping_address`='$address'
    WHERE id='$id'") or die($conn->error);
  if ($sql) {
    header('location: customers.php');
  }
}

// Customer Delete

if(isset($_GET['customer_delete'])) {
  $id = $_GET['customer_delete'];
  $conn->query("DELETE FROM customers WHERE id='$id' ") or die($conn->error);
	header('location: customers.php');
}

//Groups
$name = $percentage = $price_list ="";
$name_err = $percentage_err = $price_list_err = "";
$valid = true;
if (isset($_POST['groups_submit'])) {
  $name = $_POST['name'];
  $percentage = $_POST['percentage'];
  $price_list = $_POST['price_list'];

  //Validation
  if (empty($name)) {
    $name_err = "Name must be entered";
    $valid = false;
  }if (!is_numeric($percentage)) {
    $percentage_err = "Percentage invalid";
    $valid = false;
  }if (empty($price_list)) {
    $price_list_err = "Pricelist must be selected";
    $valid = false;
  }

  if ($valid) {
    $sql = $conn->query("INSERT INTO `cust_groups`(`name`,`percentage`,`pricelist`) VALUES ('$name','$percentage','$price_list')")or die($conn->error);
    if ($sql) {
      // var_dump($_POST);
      header('location: groups.php');
    }
  }

}

$group_row = null;

// Groups Get Data For Update
if(isset($_GET['group_update'])) {

  $group_id = $_GET['group_update'];

  $group = $conn->query("SELECT * from `cust_groups` WHERE id= '$group_id'");

  if (mysqli_num_rows($group) == 1) {

		$group_row = $group->fetch_array();
		
	}
  
}

// Groups Edit

if (isset($_POST['groups_update'])) {

  $name = $_POST['name'];
  $percentage = $_POST['percentage'];
  $price_list = $_POST['price_list'];
  $id=$_POST['id'];

  //Validation
  if (empty($name)) {

    $name_err = "Name must be entered";
    $valid = false;

  }if (!is_numeric($percentage)) {

    $percentage_err = "Percentage invalid";
    $valid = false;

  }if (empty($price_list)) {

    $price_list_err = "Pricelist must be selected";
    $valid = false;

  }

  if ($valid) {

    $sql = $conn->query("UPDATE `cust_groups` SET `name`='$name',`percentage`='$percentage',`pricelist`='$price_list' WHERE id='$id'")or die($conn->error);
    if ($sql) {

      // var_dump($_POST);
      header('location: groups.php');

    }

  }

}

// GROUP Delete

if(isset($_GET['group_delete'])) {
  $id = $_GET['group_delete'];
  $conn->query("DELETE FROM cust_groups WHERE id='$id' ") or die($conn->error);
	header('location: groups.php');
}

 ?>
