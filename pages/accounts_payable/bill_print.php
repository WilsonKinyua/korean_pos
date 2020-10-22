<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['bill_id']) || empty($_GET['bill_id'])) {
    header("Location: bill_create.php");
}
$paymentId = $_GET['bill_id'];
$res = $conn->query("SELECT id FROM bills where bills.id='$paymentId' ");
if ($res->num_rows < 1) {
    $_SESSION['error'] = 'The bill does not exists';
    header("Location: bill_create.php");
    exit();
}

$py = $conn->query("SELECT bills.*, supplier.name, supplier.email, supplier.contact FROM bills LEFT JOIN supplier  ON 
bills.supplier_id = supplier.id where bills.id='$paymentId' ");

$supply_created = $conn->query("SELECT bills.*, bill_lines.*, bill_lines.name as product_name  FROM bill_lines LEFT JOIN 
    bills ON bill_lines.bill_id=bills.id 
    where bill_lines.bill_id='$paymentId'") or die($conn->error);


$payment = $py->fetch_assoc();
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
    <div class="invoice-box rtl">
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
                                <span class="invoice-id"><?= $payment['reference'] ?></span>
                                <br>
                                <span class="t-invoice-created">Created</span>:
                                <span class="invoice-created"><?= date('m/d/Y', strtotime($payment['tran_date'])) ?></span>
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
                                <span class="t-invoice-from">INVOICE FROM</span><br>
                                <span id="company-name">Gemad Agencies Ltd</span><br>
                                <!--                            <span id="company-address"></span><br>-->
                                <span id="company-town">Nairobi</span><br>
                                <span id="company-country">Kenya</span><br>
                            </td>

                            <td class="information-client">
                                <span class="t-invoice-to">INVOICE TO</span><br>
                                <span id="client-name"><?= $payment['name'] ?></span><br>
                                <span id="client-address"><?= $payment['contact'] ?></span><br>
                                <span id="client-country">Kenya</span><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method">Payment</span>
                </td>
            </tr>

            <tr class="details">
                <td>
                    <?php
                    if (!empty($payment['bill_payment_id'])) { ?>
                        <span class="payment-method"></span><br>
                        <span class="payment-details"></span>
                    <?php } else { ?>
                        Not Paid
                    <?php }
                    ?>
                </td>
            </tr>
        </table>

        <table class="invoice-items" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td style="width: 25%; text-align: center;"><span class="t-item">Product</span></td>
                <td style="width: 20%; text-align: center;"><span class="t-item">Quantity</span></td>
                <td style="width: 24%; text-align: center;"><span class="t-price">Tax</span></td>
                <td style="width: 24%; text-align: center;"><span class="t-price">Price</span></td>
            </tr>

            <?php
            $taxTotal = 0;
            foreach ($supply_created as $product) {
                $taxTotal += $product['line_tax_total']; ?>
                <tr class="details">
                    <td style="width: 28%; text-align: center;"><span class="t-item"><?= $product['product_name'] ?></span></td>
                    <td style="width: 20%; text-align: center;"><span class="t-item"><?= number_format($product['quantity']) ?></span></td>
                    <td style="width: 24%; text-align: center;"><span class="t-item"><?= $product['line_tax_total'] ?></span></td>
                    <td style="width: 24%; text-align: center;"><span class="t-price"><?= abs((float)$product['line_amount'] / $product['quantity']) ?></span></td>
                </tr>
            <?php }
            ?>

        </table>

        <div class="invoice-summary">
            <div class="invoice-total">Tax Total: <?= $taxTotal ?></div>
            <div class="invoice-exchange"></div>
            <br>
            <div class="invoice-total">Total: <?= abs($payment['total']) ?></div>
            <div class="invoice-final"></div>
        </div>
    </div>
    <!-- Dependencies -->
    <script src="js/jquery.min.js"></script>
    <!-- Invoice -->
    <!--<script src="invoice.js"></script>-->
    <script>
        $('.print-button').on('click', function() {
            window.print()
        })
    </script>
</body>

</html>