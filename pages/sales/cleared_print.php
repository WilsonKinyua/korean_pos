<?php
session_start();
include '../utils/conn.php';
if (!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: request.php");
}
$requestId = $_GET['id'];
$salesmen_group = 7;
$res = $conn->query("SELECT sm.*, users.name as store_owner, users.mobile, users.email, products.name as product_name FROM stock_mobile as sm
    LEFT JOIN products on sm.product = products.id
    LEFT JOIN users on sm.store_owner=users.id AND users.user_group = '$salesmen_group' 
    WHERE clear_status='1' AND  store_owner='$requestId' ") or die($conn->error);

$approved_show = false;

if ($res->num_rows < 1){
    $_SESSION['error'] = 'The salesman does not exists or does not have cleared stock';
    header("Location: clear.php");
    exit();
}

if (isset($_SESSION['approved'][$requestId])){
    $approved_show = true;

    $q = "SELECT sm.*, users.name as store_owner, users.mobile, users.email, products.name as product_name FROM stock_mobile as sm 
            LEFT JOIN products on sm.product = products.id
            LEFT JOIN users on sm.store_owner=users.id AND users.user_group = '$salesmen_group' 
            WHERE sm.id IN (";
    foreach ($_SESSION['approved'][$requestId] as $item) {
        $q.=$item.",";
    }

    $q=substr($q, 0, -1).")";

    $res = $conn->query($q) or die($conn->error);
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
                            <span id="client-name"><?= $assignedProducts['store_owner'] ?></span><br>
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
            <td style="width: 33%; text-align: center;" ><span class="t-item">Product</span></td>
            <td style="width: 33%; text-align: center;" ><span class="t-item">Quantity Available</span></td>
            <td style="width: 33%; text-align: center;" ><span class="t-item">Sold</span></td>
        </tr>
        <?php
        mysqli_data_seek($res, 0);
        while ($product = $res->fetch_assoc()){ ?>
            <tr class="details">
                <td style="width: 33%; text-align: center;" ><span class="t-item"><?= $product['product_name'] ?></span></td>
                <td style="width: 33%; text-align: center;" ><span class="t-item"><?= $product['quantity_available'] ?></span></td>
                <td style="width: 33%; text-align: center;" ><span class="t-item"><?= $product['sold'] ?></span></td>
            </tr>
        <?php }
        ?>
    </table>

    <div class="footer">
        <?php
        if (isset($assignedProducts["approved_by"]) && !empty($assignedProducts["approved_by"]) && $approved_show){
            $uid = $assignedProducts["approved_by"];
            $us = $conn->query("SELECT name FROM users where id='$uid'");
            echo "<p>Approved by ".$us->fetch_assoc()['name']."</p>";
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
    });
    $(window).unload(function() {
        $.get('clear.php?clear_approved');
    });
</script>
</body>
</html>