<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['request_id']) || empty($_GET['request_id'])){
    header("Location: request.php");
}
$requestId = $_GET['request_id'];
$salesmen_group = 7;
$res = $conn->query("SELECT sma.*, users.name as saleman, users.mobile, users.email, products.name as product_name 
    FROM stock_mobile_additions as sma 
    LEFT JOIN users on sma.store_owner=users.id AND users.user_group = '$salesmen_group'
    LEFT JOIN products on sma.product = products.id where sma.doc_number='$requestId'") or die($conn->error);
if ($res->num_rows < 1){
    $_SESSION['error'] = 'The record does not exists';
    header("Location: request.php");
    exit();
}


$assignedProducts = $res->fetch_assoc();


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <!-- Dependencies -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- Invoice -->
    <link rel="stylesheet" href="css/invoice.css">
</head>

<body>
<div class="invoice-box">
    <button class="print-button"><span class="print-icon"></span></button>
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <span class="t-invoice"><img src="../../dist/img/favicon.png" style=" width:70px; height: 70px;"></span>
                        </td>

                        <td>
                            <span class="t-invoice"></span>
                            <span class="invoice-id"><?= $assignedProducts['doc_number'] ?></span>
                            <br>
                            <span class="t-invoice-created">Created</span>:
                            <span class="invoice-created"><?= date('m/d/Y', strtotime($assignedProducts['date'])) ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="information-client">
                            <span class="t-invoice-to">Assignee</span><br>
                            <span id="client-name"><?= $assignedProducts['saleman'] ?></span><br>
                            <span id="client-address"><?= $assignedProducts['mobile'] ?></span><br>
                            <span id="client-address"><?= empty($assignedProducts['email'] ) ? 'Kenya': $assignedProducts['email'] ?></span><br>
                            <span id="company-country">Kenya</span><br>
                        </td>

                        <td class="information-company">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="invoice-items" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td ><span class="t-item">Product</span></td>
            <td ><span class="t-item">Quantity Assigned</span></td>
        </tr>
        <?php
        mysqli_data_seek($res, 0);
        while ($product = $res->fetch_assoc()){ ?>
            <tr class="details">
                <td ><span class="t-item"><?= $product['product_name'] ?></span></td>
                <td ><span class="t-item"><?= $product['quantity_added'] ?></span></td>
            </tr>
        <?php }
        ?>
    </table>

    <div class="footer">
        <?php
        if (isset($assignedProducts["assigned_by"]) && !empty($assignedProducts["assigned_by"])){
            $uid = $assignedProducts["assigned_by"];
            $us = $conn->query("SELECT name FROM users where id='$uid'");
            echo "<p>Assigned by ".$us->fetch_assoc()['name']."</p>";
        }
        ?>

    </div>

</div>
<!-- Dependencies -->
<script src="js/jquery.min.js"></script>
<!-- Invoice -->
<!--<script src="invoice.js"></script>-->
<script>
    $('.print-button').on('click', function () {
        window.print()
    })
</script>
</body>
</html>