<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['requisition_id']) || empty($_GET['requisition_id'])){
    header("Location: requisition_create.php");
}
$invoiceId = $_GET['requisition_id'];
$res = $conn->query("SELECT requisition.*, c.name, c.contact FROM requisition LEFT JOIN supplier as c ON requisition.supplier_id = c.id where requisition.id='$invoiceId' ");
if ($res->num_rows < 1){

    $_SESSION['error'] = 'The requisition does not exists';

    header("Location: requisition_create.php");
    exit();
}


$productsPurchased = $conn->query("SELECT requisition.*, requisition_lines.*, products.name as product_name  FROM requisition_lines LEFT JOIN 
    requisition ON requisition_lines.requisition_id=requisition.id 
    LEFT JOIN products on requisition_lines.product = products.id
    where requisition_lines.requisition_id='$invoiceId'") or die($conn->error);

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
                            <span class="t-invoice"></span>
                        </td>

                        <td>
                            <span class="t-invoice"></span>
                            <span class="invoice-id"><?= $invoice['reference'] ?></span>
                            <br>
                            <span class="t-invoice-created">Created</span>:
                            <span class="invoice-created"><?= date('m/d/Y', strtotime($invoice['tran_date'])) ?></span>
                            <br>
                           
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
                            <span class="t-invoice-from">ORDER FROM</span><br>
                            <span id="company-name">Gemad Agencies Ltd</span><br>
<!--                            <span id="company-address"></span><br>-->
                            <span id="company-town">Nairobi</span><br>
                            <span id="company-country">Kenya</span><br>
                        </td>

                        <td class="information-client">
                            <span class="t-invoice-to">ORDER TO</span><br>
                            <span id="client-name"><?= $invoice['name'] ?></span><br>
                            <span id="client-address"><?= $invoice['contact'] ?></span><br>
<!--                            <span id="client-town"></span><br>-->
                            <span id="client-country">Kenya</span><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>



    <table class="invoice-items " cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 33%; text-align: center;"><span class="t-item">Product</span></td>
            <td style="width: 33%; text-align: center;"><span class="t-item">Quantity</span></td>
        </tr>
        <?php
        foreach ($productsPurchased as $product){ ?>
            <tr class="details">
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['product_name'] ?></span></td>
                <td style="width: 33%; text-align: center;"><span class="t-item"><?= $product['quantity'] ?></span></td>
            </tr>
        <?php }
        ?>
    </table>

    <div class="invoice-summary">
        <div class="invoice-final"></div>
        <div class="invoice-exchange"></div>
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