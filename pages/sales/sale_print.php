<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['sale_id']) || empty($_GET['sale_id'])){
    header("Location: sales_create.php");
}
$purchaseId = $_GET['sale_id'];
$res = $conn->query("SELECT ns.*, c.cust_name, c.cust_contact, users.name as saleman FROM new_sale as ns 
    LEFT JOIN users on ns.salesman=users.id
    LEFT JOIN customers as c ON ns.customer = c.id where ns.doc_number='$purchaseId'") or die($conn->error);
if ($res->num_rows < 1){
    $_SESSION['error'] = 'The sale does not exists';
    header("Location: sales_create.php");
    exit();
}


$productsSold = $conn->query("SELECT ns.*, products.*,products.name as product_name  FROM new_sale as ns 
    LEFT JOIN products on ns.product = products.id
    where ns.doc_number='$purchaseId'") or die($conn->error);

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
                            <span class="invoice-created"><?= date('Y M d', strtotime($purchase['date'])) ?></span>
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
                            <span class="t-invoice-from">Purchsed From</span><br>
                            <span id="company-name">Gemad Agencies Ltd</span><br>
                            <!--                            <span id="company-address"></span><br>-->
                            <span id="company-town">Nairobi</span><br>
                            <span id="company-country">Kenya</span><br>
                        </td>

                        <td class="information-client">
                            <span class="t-invoice-to">Sold To</span><br>
                            <span id="client-name"><?= $purchase['cust_name'] ?></span><br>
                            <span id="client-address"><?= $purchase['cust_contact'] ?></span><br>
                            <span id="company-country">Kenya</span><br>
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
        foreach ($productsSold as $product){
            $cid = $purchase['customer'];
            $cust = $conn->query("SELECT * FROM customers INNER JOIN cust_groups ON customers.cust_group=cust_groups.id WHERE customers.id='$cid'") or die($conn->error);
            $array = $cust->fetch_array();
            $price = 0;
            $pricelist = $array['pricelist'];
            if ($pricelist==0) {
                $price = $product['distributor'];
            }elseif ($pricelist == 1) {
                $price = $product['stockist'];
            }elseif ($pricelist == 2) {
                $price = $product['stockist'];
            }elseif ($pricelist == 3) {
                $price = $product['wholesale'];
            }else {
                $price = $product['retail'];
            }
            ?>
            <tr class="details">
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['product_name'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['quantity'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-price"><?= $price ?></span></td>
            </tr>
        <?php }
        ?>
    </table>

    <div class="invoice-summary">
        <div class="invoice-total">Paid Amount: <?= $purchase['sale_price'] ?></div>
        <div class="invoice-final"></div>
        <div class="invoice-exchange"></div>
    </div>

    <div class="footer">
        <p>Served by <?= $purchase["saleman"] ?></p>
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