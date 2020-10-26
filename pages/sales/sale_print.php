<?php
session_start();
include '../utils/conn.php';

if (!isset($_GET['sale_id']) || empty($_GET['sale_id'])){
    header("Location: sales_create.php");
}
$invoiceId = $_GET['sale_id'];

$res = $conn->query("SELECT sales.*, products.item_name as name FROM sales LEFT JOIN products ON sales.product = products.id where sales.reference='$invoiceId' ");



$productsPurchased = $conn->query("SELECT sales.*, products.item_name as name FROM sales LEFT JOIN products ON sales.product = products.id where sales.reference='$invoiceId' ") or die($conn->error);

$invoice = $res->fetch_assoc();
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
                            <span class="t-invoice"><img style="width: 250px;" src="../../dist/img/logo.jpg" alt="Logo Company"></span>
                        </td>

                        <td>
                            <span class="t-invoice"></span>
                            <span class="invoice-id"> RECEIPT NUMBER <br><?= $invoice['reference'] ?></span>
                            <br>
                            <span class="t-invoice-created">Created</span>:
                            <span class="invoice-created"><?= date('m/d/Y', strtotime($invoice['tran_date'])) ?></span>
                            <br>
                           
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information" >
            <td colspan="2">
                <table>
                    <tr>
                        <td class="information-company" style="font-weight:900; font-size:15px; text-transform:uppercase;">
                            <span class="t-invoice-from">ORDER FROM</span><br>
                            <span id="company-name"> Korean Kenya Solar</span><br>
<!--                            <span id="company-address"></span><br>-->
                            <span id="company-town">Kaunda Street, QueensWay House </span><br>
                            <span id="company-country">Nairobi Kenya</span><br>
                        </td>

                        <td class="information-client" style="font-weight:900; font-size:15px; text-transform:uppercase;">
                            <span class="t-invoice-to">CREATED BY</span><br>
                            <span id="company-name">Korean Kenya Solar</span><br>
                            <span id="company-town">Kaunda Street, QueensWay House </span><br>
                            <span id="company-country">Nairobi Kenya</span><br>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
    </table>



    <table class="invoice-items " cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 33%; text-align: center;"><span class="t-item">Product</span></td>
            <td style="width: 15%; text-align: center;"><span class="t-item">Quantity</span></td>
            <td style="width: 33%; text-align: center;"><span class="t-item">Price</span></td>
            <td style="width: 33%; text-align: center;"><span class="t-item">SubTotal</span></td>
        </tr>
        <?php
        $total=0;
        foreach ($productsPurchased as $product){
            $total += $product['sub_total']
            ?>
        
            <tr class="details">
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['name'] ?></span></td>
                <td style="width: 15%; text-align: center;"><span class="t-item"><?= $product['qty'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['price'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= ($product['price'] * $product['qty']) ?></span></td>
            </tr>
        <?php }
        ?>
    </table>
<hr>
    <div class="invoice-summary">
        <div class="invoice-final" style="font-weight: 900; font-size:15px; margin-right:80px">Total Amount: <?php echo number_format($total,2); ?></div>
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