<?php
include '../utils/conn.php';
$update = false;

$name = "";
$shell_cost = "";
$bottles_number = "";
$bottles_price = "";
$option = "";
$selling_cost = "";

$category_err = $shells_err = $bottles_err = $cost_err=$selling_cost_err = "";
$valid = true;

if (isset($_POST['categories_submit'])) {

	$name = $_POST['name'];
	
	if ($valid) {
		$conn->query("INSERT INTO `product_categories`(`name`) VALUES ('$name')") or die($conn->error);

		header('location: categories.php');
	}


}

if (isset($_GET['category_edit'])) {

	$id = $_GET['category_edit'];

	$res = $conn->query("SELECT * FROM product_categories WHERE id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
        $name = $row['name'];
        $update=true;
    }
}

if (isset($_GET['category_delete'])) {
	$id = $_GET['category_delete'];
	$conn->query("DELETE FROM product_categories WHERE id='$id'") or die($conn->error);

	header('location: categories.php');
}


if (isset($_POST['categories_update'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];

	$conn->query("UPDATE `product_categories` SET `name`='$name' WHERE id='$id'") or die($conn->error);

	header('location: categories.php');
}



// 		Add products code 
if (isset($_POST['product_submit'])) {

	$product_name 		= $_POST['product_name'];
	$category 			= $_POST['category'];
	$cost 				= $_POST['cost_price'];
	$serial 			= $_POST['serial'];
	$capacity 			= $_POST['capacity'];
	$manu 				= $_POST['manu'];
	$tech 				= $_POST['tech'];


	$conn->query("INSERT INTO `products`(`item_name`, `category`, `price`, `serial_number`, `manufacturer`, `capacity`,`technical_details`) 
			VALUES ('$product_name','$category','$cost', '$serial','$manu','$capacity','$tech')") or die($conn->error);
	setcookie("product_success", true, time()+10);
	header('location: products_create.php');

}


if (isset($_GET['product_edit'])) {
	$id = $_GET['product_edit'];
	$res = $conn->query("SELECT * FROM products WHERE id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
        $product_name = $row['name'];
        $product_update=true;
        $category = $row['category'];
        $selling_cost = $row['selling_cost'];
				$stockist_cost = $row['stockist'];
				$wholesale_cost = $row['wholesale'];
				$retail_cost = $row['retail'];
				$distributor_cost = $row['distributor'];
    }
}

if (isset($_GET['product_delete'])) {
	$id = $_GET['product_delete'];
	$conn->query("DELETE FROM products WHERE id='$id'") or die($conn->error);

	header('location: products.php');
}

if (isset($_POST['product_update'])) {
	$id = $_POST['id'];
	$product_name = $_POST['product_name'];
	$category =  $_POST['category'];
	$cost =  $_POST['cost'];
	$selling_cost = $_POST['selling_cost'];
	$stockist_cost = $_POST['stockist_cost'];
	$wholesale_cost = $_POST['wholesale_cost'];
	$retail_cost = $_POST['retail_cost'];
	$distributor_cost = $_POST['distributor_cost'];

	$conn->query("UPDATE `products` SET `name`='$product_name', `category`='$category', `price`='$selling_cost', `selling_cost`='$selling_cost', `distributor`='$distributor_cost', `stockist`='$stockist_cost', `wholesale`='$wholesale_cost',`retail`='$retail_cost' WHERE id='$id'") or die($conn->error);

	header('location: list.php');
}

// Suppliers
$supplier_id ="";
$supplier_name  = "";
$supplier_location = "";
$suppier_address = "";
$supplier_phone = "";
$supplier_email = "";
$supplier_pin = "";
$supplier_update= false;
$supplier_name_err = $location_err = $address_err = $phone_err = $email_err = $kra_err ="";
$valid = true;

if (isset($_POST['supplier_submit'])) {
	$supplier_name  = $_POST['supplier_name'];
	$supplier_location = $_POST['supplier_location'];
	$suppier_address = $_POST['suppier_address'];
	$supplier_phone = $_POST['supplier_phone'];
	$supplier_email = $_POST['supplier_email'];
	$supplier_pin = $_POST['supplier_pin'];

	// Validating Fields
	if (empty($supplier_name)) {
		$supplier_name_err = "Name is required";
		$valid = false;
	}

	if (!preg_match("/^[a-zA-Z ]*$/",$supplier_name)) {
	 	$supplier_name_err = "Only letters and white space allowed";
	 	$valid = false;
	}
	if (empty($supplier_location)) {
		$location_err = "Location is required";
		$valid = false;
	}
	if (empty($suppier_address)) {
		$address_err = "Address is required";
		$valid = false;
	}
	if (!is_numeric($supplier_phone)) {
		$phone_err = "Phone Number is required";
		$valid = false;
	}
	if (!filter_var($supplier_email, FILTER_VALIDATE_EMAIL)) {
		$email_err = "Email is invalid";
		$valid = false;
	}
	if (empty($supplier_pin)) {
		$kra_err = "KRA PIN is required";
		$valid = false;
	}
	if ($valid) {
		$insert = $conn->query("INSERT INTO `suppliers`(`supplier_name`, `supplier_location`, `supplier_address`, `supplier_phone`, `supplier_email`, `supplier_pin`) VALUES ('$supplier_name','$supplier_location','$suppier_address','$supplier_phone','$supplier_email','$supplier_pin')") or die($conn->error);

		    $last_id = $conn->insert_id;
		    $conn->query("INSERT INTO `accounts`(`category`, `owner`, `amount_credited`, `amount_paid`) VALUES ('0','$last_id','0','0')") or die($conn->error);
		header('location: suppliers.php');
	}
}

if (isset($_GET['supplier_edit'])) {
	$id = $_GET['supplier_edit'];
	$res = $conn->query("SELECT * FROM suppliers WHERE supplier_id='$id'") or die($conn->error);
	if (mysqli_num_rows($res) == 1){
        $row = $res->fetch_array();
        $supplier_name  = $row['supplier_name'];
		$supplier_location = $row['supplier_location'];
		$suppier_address = $row['supplier_address'];
		$supplier_phone = $row['supplier_phone'];
		$supplier_email = $row['supplier_email'];
		$supplier_pin = $row['supplier_pin'];
		$supplier_update= true;
    }
}
if (isset($_GET['supplier_delete'])) {
	$id = $_GET['supplier_delete'];
	$conn->query("DELETE FROM suppliers WHERE supplier_id='$id'") or die($conn->error);

	header('location: suppliers.php');
}
if (isset($_POST['supplier_update'])) {
	$id = $_POST['supplier_id'];
	$supplier_name  = $_POST['supplier_name'];
	$supplier_location = $_POST['supplier_location'];
	$suppier_address = $_POST['suppier_address'];
	$supplier_phone = $_POST['supplier_phone'];
	$supplier_email = $_POST['supplier_email'];
	$supplier_pin = $_POST['supplier_pin'];

	$conn->query("UPDATE `suppliers` SET `supplier_name`='$supplier_name',`supplier_location`='$supplier_location',`supplier_address`='$suppier_address',`supplier_phone`='$supplier_phone',`supplier_email`='$supplier_email',`supplier_pin`='$supplier_pin' WHERE supplier_id='$id'") or die($conn->error);

	header('location: suppliers.php');
}
?>
