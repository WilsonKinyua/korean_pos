<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['purchase_id']) || empty($_GET['purchase_id'])){
    header("Location: purchases_create.php");
}
$purchaseId = $_GET['purchase_id'];
$res = $conn->query("SELECT sd.*, supplier.name, supplier.contact, supplier.email FROM stock_detail as sd 
    LEFT JOIN supplier ON sd.store = supplier.id where sd.doc_number='$purchaseId' ");
if ($res->num_rows < 1){
    $_SESSION['error'] = 'The purchase does not exists';
    header("Location: purchases_create.php");
    exit();
}


$productsPurchased = $conn->query("SELECT sd.*, products.name as product_name  FROM stock_detail as sd 
    LEFT JOIN products on sd.product = products.id
    where sd.doc_number='$purchaseId'") or die($conn->error);

$purchase = $res->fetch_assoc();
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
                            <span class="invoice-id"><?= $purchase['doc_number'] ?></span>
                            <br>
                            <span class="t-invoice-created">Created</span>:
                            <span class="invoice-created"><?= date('m/d/Y', strtotime($purchase['date'])) ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="information-company">
                            <span class="t-invoice-from">Customer</span><br>
                            <span id="company-name">Gemad Agencies Ltd</span><br>
<!--                            <span id="company-address"></span><br>-->
                            <span id="company-town">Nairobi</span><br>
                            <span id="company-country">Kenya</span><br>
                        </td>

                        <td class="information-client">
                            <span class="t-invoice-to">Supplier</span><br>
                            <span id="client-name"><?= $purchase['name'] ?></span><br>
                            <span id="client-address"><?= $purchase['contact'] ?></span><br>
                            <span id="client-address"><?= $purchase['email'] ?></span><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="invoice-items" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 33%; text-align: center;"><span class="t-item">Product</span></td>
            <td style="width: 33%; text-align: center;"><span class="t-item">Quantity</span></td>
            <td style="width: 33%; text-align: center;"><span class="t-price">Subtotal</span></td>
        </tr>
        <?php
        $total = 0;
        $totalTax = 0;
        foreach ($productsPurchased as $product){
            $totalTax += $product['line_tax_total'];
            $total += $product['total_amount']; ?>
            <tr class="details">
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['product_name'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['trn_qty'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-price"><?= abs((float)$product['total_amount']) ?></span></td>
            </tr>
        <?php }
        ?>
    </table>

    <div class="invoice-summary">
        <div class="invoice-final">Total Tax:  <?= $totalTax ?></div>
        <div class="invoice-total">Total: <?= $total ?></div>
        <div class="invoice-exchange"></div>
    </div>

    <div class="footer">
        <?php
        if (isset($purchase["received_by"]) && !empty($purchase["received_by"])){
            $uid = $purchase["received_by"];
            $us = $conn->query("SELECT name FROM users where id='$uid'");
            echo "<p>Received by ".$us->fetch_assoc()['name']."</p>";
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