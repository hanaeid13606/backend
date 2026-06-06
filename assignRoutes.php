<?php
require "connection.php"; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['aircraftID']) || empty($_POST['routeID'])) {
        http_response_code(422);
        echo json_encode(["error" => "aircraftID and routeID are required"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO assignments (aircraftID, routeID) VALUES (?, ?)");
        $stmt->execute([
            $_POST['aircraftID'],
            $_POST['routeID']
        ]);
        echo json_encode(["message" => "Aircraft assigned to route"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
