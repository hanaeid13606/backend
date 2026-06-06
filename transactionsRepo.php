<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getAllTransactions($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM transactions");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
function insertTransaction($conn, $data) {
    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO transactions(type, amount, date) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['type'],
            $data['amount'],
            $data['date']
        ]);
        $stmt2 = $conn->prepare("UPDATE airline SET currentBalance = currentBalance + ? WHERE airlineID = ?");
        $stmt2->execute([
            $data['amount'],
            $data['airlineID']
        ]);

        $conn->commit();
        return ["message" => "Transaction successful"];
    } catch (Exception $e) {
        $conn->rollBack();
        return ["error" => $e->getMessage()];
    }
}
?>