<?php
// $conn = mysqli_connect('localhost','root','','premierdb') or die($conn->error);
include '../utils/conn.php';
$date = date("Y-m-d");
$username = "";

if (!isset($_SESSION['userId'])) {
    header('location: ../logout.php');
}else{
    $userId = $_SESSION['userId'];
}

$cust_err = "";
$type_err = $acc_err = $code_err = $doc_err= $amt_err = "";

if (isset($_POST['save_print'])) {

    $date               =  date('Y-m-d H:i:s');
    $requisition_date  =  $date;
    $description        =  $_POST['description'];
    $doc_number         =  $_POST['doc_number'];
    $total_amount       =  $_POST['total_amount'];
    $supplier_id        =  $_POST['customer_name'];
    $user           = $_SESSION['userId'];

    if (empty($supplier_id)) {

        $_SESSION['error_spplier'] = 'Suppler must be selected';
        header("Location: requisition_create.php");
    }

    if (empty($total_amount)) {

        header("Location: requisition_create.php");
    }

        $conn->query("INSERT INTO `requisition`(`tran_date`, `description`, `reference`, `total`, `status`, `supplier_id`,`user_id`) 
                                      VALUES ('$requisition_date','$description','$doc_number','$total_amount',0,'$supplier_id','$user')") or die($conn->error);
        $requisition_id = $conn->insert_id;

        foreach ($_SESSION['requisition_cart'] as $key => $values) {
            $name = $values['id'];
            $qty = $values['quantity'];
            $price = $values['price'];
            $line_amount = $values['quantity'] * $values['price'];
            $line_tax_total = ($values['tax_total']);
            $bill_lines = $conn->query("INSERT INTO `requisition_lines`(`product`, `quantity`, `line_amount`, `requisition_id`) 
              VALUES ('$name','$qty','$line_amount',$requisition_id)") or die($conn->error);
        }

        unset($_SESSION['requisition_cart']);
        $_SESSION['success'] = 'Order(s) was created successfully';
        $_SESSION['dont_close_alert'] = $requisition_id;
        header("Location: requisition_create.php");
        exit();

}



if (isset($_POST['save_sale'])) {

    $date               =  date('Y-m-d H:i:s');
    $requisition_date  =  $date;
    $description        =  $_POST['description'];
    $doc_number         =  $_POST['doc_number'];
    $total_amount       =  $_POST['total_amount'];
    $supplier_id        =  $_POST['customer_name'];
    $user           = $_SESSION['userId'];

    if (empty($supplier_id)) {

        $_SESSION['error_spplier'] = 'Suppler must be selected';
        header("Location: requisition_create.php");
    }

    if (empty($total_amount)) {

        header("Location: requisition_create.php");
    }

        $conn->query("INSERT INTO `requisition`(`tran_date`, `description`, `reference`, `total`, `status`, `supplier_id`,`user_id`) 
                                      VALUES ('$requisition_date','$description','$doc_number','$total_amount',0,'$supplier_id','$user')") or die($conn->error);
        $requisition_id = $conn->insert_id;

        foreach ($_SESSION['requisition_cart'] as $key => $values) {
            $name = $values['id'];
            $qty = $values['quantity'];
            $price = $values['price'];
            $line_amount = $values['quantity'] * $values['price'];
            $line_tax_total = ($values['tax_total']);
            $bill_lines = $conn->query("INSERT INTO `requisition_lines`(`product`, `quantity`, `line_amount`, `requisition_id`) 
              VALUES ('$name','$qty','$line_amount',$requisition_id)") or die($conn->error);
        }

        unset($_SESSION['requisition_cart']);
        $_SESSION['success'] = 'Order(s) was created successfully';
        header("Location: requisition_create.php");
        exit();

}

?>
