<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getTransactionsSummary($conn) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) as totalTransactions, SUM(amount) as totalAmount FROM transactions");
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
?>
