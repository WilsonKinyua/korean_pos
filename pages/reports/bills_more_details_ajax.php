<?php 

    include '../utils/conn.php';

    $bill_id = $_POST["bill_id"];

    $res = $conn->query("SELECT * FROM `bill_lines` WHERE bill_lines.bill_id='$bill_id'") or die($conn->error);

    $results = "";

    while ($row = $res->fetch_assoc()) {

    $results .= "<tr>";
        $results .= "<td>".$row['name']."</td>";
        $results .= "<td>".$row['quantity']."</td>";
        $results .= "<td>".abs($row['line_amount'])."</td>";
        $results .= "<td>".$row['line_tax_total']."</td>";
    $results .= "</tr>";
    
    } 

    echo json_encode([
        "results" => $results
    ])

?>