<?php
require "connection.php";
require "helpers/response.php";
require "helpers/validator.php";

try {
    $conn->beginTransaction();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->query("SELECT * FROM transactions");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    jsonResponse($rows, 200);
    exit;
}

    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $aircraftID = $_POST['aircraftID'];
    $airlineID = $_POST['airlineID'];

    $stmt = $conn->prepare("INSERT INTO transactions(type,amount,date) VALUES(?,?,?)");
    $stmt->execute([$type, $amount, $date]);

    $stmt2 = $conn->prepare("UPDATE airline SET currentBalance=currentBalance+? WHERE airlineID=?");
    $stmt2->execute([$amount, $airlineID]);

    $conn->commit();
    jsonResponse(["message"=>"Transaction successful"],200);

} catch(Exception $e) {
    $conn->rollBack();
    jsonResponse(["error"=>$e->getMessage()],500);
}
?>
