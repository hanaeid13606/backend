<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getAllTransactions($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM transactions");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        jsonResponse($rows, 200);
    } catch (Exception $e) {
        jsonResponse(["error" => $e->getMessage()], 500);
    }
}

function createTransaction($conn, $data) {
    if (empty($data['type']) || empty($data['amount']) || empty($data['date']) || empty($data['airlineID'])) {
        http_response_code(422);
        jsonResponse(["error" => "type, amount, date, and airlineID are required"], 422);
        return;
    }

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO transactions(type, amount, date) VALUES (?, ?, ?)");
        $stmt->execute([$data['type'], $data['amount'], $data['date']]);

        $stmt2 = $conn->prepare("UPDATE airline SET currentBalance = currentBalance + ? WHERE airlineID = ?");
        $stmt2->execute([$data['amount'], $data['airlineID']]);

        $conn->commit();
        jsonResponse(["message" => "Transaction successful"], 200);

    } catch (Exception $e) {
        $conn->rollBack();
        jsonResponse(["error" => $e->getMessage()], 500);
    }
}
?>