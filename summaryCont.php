<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function GetTransactionsSummary($conn) {
    try {
        $summary = GetTransactionsSummary($conn);
        if ($summary) {
            Response(200, "transactions summary retrieved", $summary);
        } else {
            Response(404, "No transactions found");
        }
    } catch (Exception $e) {
        Response(500, $e->getMessage());
    }
}
?>