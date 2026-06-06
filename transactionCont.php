<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function GetAllTransactions($conn) {
    $transactions = GetAllTransactionsRepo($conn);
    Response(200, "transactions retrieved", $transactions);
}

function CreateTransaction($conn, $data) {
    try {
        $conn->beginTransaction();

        $result = InsertTransaction($conn, $data['type'], $data['amount'], $data['date']);
        if (!$result) {
            throw new Exception("Failed to insert transaction");
        }

        $update = UpdateAirlineBalance($conn, $data['airlineID'], $data['amount']);
        if (!$update) {
            throw new Exception("Failed to update airline balance");
        }

        $conn->commit();
        Response(201, "Transaction successful");
    } catch (Exception $e) {
        $conn->rollBack();
        Response(500, $e->getMessage());
    }
}
?>