<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function insertAssignment($conn, $data) {
    try {
        $stmt = $conn->prepare("INSERT INTO assignments (aircraftID, routeID) VALUES (?, ?)");
        $stmt->execute([
            $data['aircraftID'],
            $data['routeID']
        ]);
        return ["message" => "Aircraft assigned to route"];
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
?>
