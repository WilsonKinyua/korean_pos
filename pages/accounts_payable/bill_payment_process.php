<?php
include '../utils/conn.php';

$cust_err = "";
$date = date('Y-m-d H:i:s');

$type_err = $acc_err  = $doc_err = $amt_err = $inv_err = "";

$valid = true;

if (isset($_POST['save_payment'])) {
    $doc_number     = $_POST['doc_number'];
    $salesman       = $_SESSION['userId'];
    $customer       = $_POST['supplier_name'];
    $account        = $_POST['account_id'];
    $description    = $_POST['description'];
    $payment_type   = $_POST['payment_type'];

    $invoices = isset($_POST['invoices']) ? $_POST['invoices'] : [];

    if (empty($customer)) {
        $cust_err = "A customer must be selected";
        $valid = false;
    }
    if (empty($doc_number)) {
        $doc_err = "Invoice  must be provided";
        $valid = false;
    }
    if (empty($account)) {
        $acc_err = "An account must be selected";
        $valid = false;
    }
    if (empty($payment_type)) {
        $type_err = "A payment mode must be selected";
        $valid = false;
    }
    if (count($invoices) == 0) {
        $inv_err = "Invoices must be Selected";
        $valid = false;
    }

    $total = 0;

    foreach ($invoices as $invoice) {
        $res = $conn->query("SELECT id, total from bills WHERE id='$invoice'");
        if ($res->num_rows < 0) {
            $inv_err = "Some Invoices does not exist";
            $valid = false;
        }
        $row = $res->fetch_assoc();
        $total += (float)$row['total'];
    }

    if ($valid) {
        $conn->query("INSERT INTO `bill_payments`(`tran_date`, `description`, `reference`, `total`, `coa_id`, `payment_type`) 
                                VALUES ('$date','$description', '$doc_number', '$total', '$account', '$payment_type')");
        $paymentId = $conn->insert_id;
        $conn->query('SET foreign_key_checks = 0');
        foreach ($invoices as $i) {

            $conn->query("UPDATE bills SET `bill_payment_id`='$paymentId', `status`='1' WHERE id='$i'")
                or die($conn->error);
        }
        $conn->query('SET foreign_key_checks = 1');

        unset($_SESSION['payment_customer']);
        $_SESSION['success'] = 'The invoice payment(s) were successfully recorded';

        header('location: bill_payment_create.php');
        exit();
    }
}

if (isset($_POST['save_print'])) {
    $doc_number = $_POST['doc_number'];
    $salesman = $_SESSION['userId'];
    $customer = $_POST['supplier_name'];
    $account = $_POST['account_id'];
    $description = $_POST['description'];
    $payment_type = $_POST['payment_type'];
    $invoices = isset($_POST['invoices']) ? $_POST['invoices'] : [];

    if (empty($customer)) {
        $cust_err = "A Supplier must be selected";
        $valid = false;
    }
    if (empty($doc_number)) {
        $doc_err = "Invoice id must be provided";
        $valid = false;
    }
    if (empty($account)) {
        $acc_err = "An account must be selected";
        $valid = false;
    }
    if (empty($payment_type)) {
        $type_err = "A payment mode must be selected";
        $valid = false;
    }
    if (count($invoices) == 0) {
        $inv_err = "Invoices must be Selected";
        $valid = false;
    }

    $total = 0;

    foreach ($invoices as $invoice) {
        $res = $conn->query("SELECT id, total from bills WHERE id='$invoice'");
        if ($res->num_rows < 0) {
            $inv_err = "Some Invoices does not exist";
            $valid = false;
        }
        $row = $res->fetch_assoc();
        $total += (float)$row['total'];
    }

    if ($valid) {
        $conn->query("INSERT INTO `bill_payments`(`tran_date`, `description`, `reference`, `total`, `coa_id`, `payment_type`) 
                        VALUES ('$date','$description', '$doc_number', '$total', '$account', '$payment_type')");
        $paymentId = $conn->insert_id;
        $conn->query('SET foreign_key_checks = 0');
        foreach ($invoices as $i) {

            $conn->query("UPDATE bills SET `bill_payment_id`='$paymentId', `status`='1' WHERE id='$i'")
                or die($conn->error);
        }
        $conn->query('SET foreign_key_checks = 1');

        unset($_SESSION['payment_customer']);
        $_SESSION['success'] = 'The invoice payment(s) were successfully recorded';

        $_SESSION['dont_close_alert'] = $paymentId;

        header('location: bill_payment_create.php');
        exit();
    }
}
