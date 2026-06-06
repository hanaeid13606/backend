<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getAllAircraft($conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM aircraft");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
function insertAircraft($conn, $data) {
    try {
        $stmt = $conn->prepare("INSERT INTO aircraft(model, capacity, airlineOwnsIt) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['model'],
            $data['capacity'],
            $data['airlineOwnsIt']
        ]);
        return ["message" => "Aircraft created"];
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
?>
