<?php
include '../utils/conn.php';

$cust_err = "";
$date = date('Y-m-d H:i:s');

$type_err = $acc_err  = $doc_err= $amt_err  = "";

$valid = true;

if(isset($_POST['save'])) {
    $doc_number = $_POST['doc_number'];
    // $supplier = $_POST['supplier'];
    $salesman = $_SESSION['userId'];
    $customer = $_POST['customer_name'];
    $account = $_POST['account_id'];
    $description = $_POST['description'];
    $payment_type = $_POST['payment_type'];
    $amount = $_POST['amount'];

    $tax_rate       = $_POST["tax_rate"];
    $tax_in_ex      = $_POST["tax_in_ex"];

    if($tax_in_ex  == 'inclusive') {

        $line_tax_total = ($amount - ($amount / (1 + ($tax_rate/100))));

    } else {

       $line_tax_total = ($amount * ($tax_rate/100));

    }

    if($tax_in_ex  == 'inclusive') {

        $amount = $amount;

    } else {

       $amount = $amount + ($amount * ($tax_rate/100));

    }

    if (empty($customer)) {
        $cust_err = "Received from is required";
        $valid = false;
    }
    if (empty($doc_number)) {
        $doc_err = "payment id must be provided";
        $valid = false;
    }
    if (empty($account)){
        $acc_err = "An account must be selected";
        $valid = false;
    }
    if (empty($payment_type)) {
        $type_err = "A payment mode must be selected";
        $valid = false;
    }
    if (empty($amount)) {
        $type_err = "Amount is required";
        $valid = false;
    }

    $coa = 110;
    $neg = 0 - (float) $amount;

    if ($valid){
        $conn->query("INSERT INTO `received_moneys`(`tran_date`, `description`, `reference`, `total`, `customer_id`, `coa_id`) VALUES 
                                                                                                                ('$date', '$description', '$doc_number', '$amount', '$customer', '$coa')") or die($conn->error);
        $rm_id = $conn->insert_id;

        $conn->query("INSERT INTO `received_money_lines`(`line_amount`, `received_money_id`, `line_coa_id`,`line_tax_total`) VALUES ('$neg', '$rm_id', '$account','$line_tax_total')") or die($conn->error);

        $_SESSION['success'] = 'Received money was recorded';
        header('Location: received_monies.php');
        exit();
    }
}
if(isset($_POST['save_print'])) {
    $doc_number = $_POST['doc_number'];
    // $supplier = $_POST['supplier'];
    $salesman = $_SESSION['userId'];
    $customer = $_POST['customer_name'];
    $account = $_POST['account_id'];
    $description = $_POST['description'];
    $payment_type = $_POST['payment_type'];
    $amount = $_POST['amount'];

    $tax_rate       = $_POST["tax_rate"];
    $tax_in_ex      = $_POST["tax_in_ex"];

    if($tax_in_ex  == 'inclusive') {

        $line_tax_total = ($amount - ($amount / (1 + ($tax_rate/100))));

    } else {

       $line_tax_total = ($amount * ($tax_rate/100));

    }

    if (empty($customer)) {
        $cust_err = "Received from is required";
        $valid = false;
    }
    if (empty($doc_number)) {
        $doc_err = "payment id must be provided";
        $valid = false;
    }
    if (empty($account)){
        $acc_err = "An account must be selected";
        $valid = false;
    }
    if (empty($payment_type)) {
        $type_err = "A payment mode must be selected";
        $valid = false;
    }
    if (empty($amount)) {
        $type_err = "Amount is required";
        $valid = false;
    }

    $coa = 110;
    $neg = 0 - (float) $amount;

    if ($valid){
        $conn->query("INSERT INTO `received_moneys`(`tran_date`, `description`, `reference`, `total`, `customer_id`, `coa_id`, `payment_type`) VALUES 
                                                                                                                ('$date', '$description', '$doc_number', '$amount', '$customer', '$coa', '$payment_type')") or die($conn->error);
        $rm_id = $conn->insert_id;

        $conn->query("INSERT INTO `received_money_lines`(`line_amount`, `received_money_id`, `line_coa_id`,`line_tax_total`) VALUES ('$neg', '$rm_id', '$account','$line_tax_total')") or die($conn->error);

        $_SESSION['success'] = 'Received money was recorded';
        $_SESSION['dont_close_alert'] = $rm_id;
        header('Location: received_monies.php');
        exit();
    }
}