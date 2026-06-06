<?php
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) as totalTransactions, SUM(amount) as totalAmount FROM transactions");
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>

