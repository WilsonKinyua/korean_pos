<?php 

    include '../utils/conn.php';

    $invoice_id = $_POST["invoice_id"];

    $res = $conn->query(
                            
        "SELECT 
            invoice_lines.id as invoice_line_id,
            invoice_lines.quantity,
            products.name,
            invoice_lines.line_tax_total,
            invoice_lines.line_amount
        FROM `invoice_lines`
        INNER JOIN products ON products.id=invoice_lines.product
        WHERE invoice_lines.invoice_id='$invoice_id'
        "

    ) or die($conn->error);

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