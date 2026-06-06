<?php
require "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $stmt = $conn->prepare("SELECT * FROM routes");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

elseif ($method == "POST") {
    if (!empty($_POST['origin']) && !empty($_POST['destination']) && !empty($_POST['distance'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO routes(origin, destination, distance) VALUES (?, ?, ?)");
            $stmt->execute([
                $_POST['origin'],
                $_POST['destination'],
                $_POST['distance']
            ]);
            echo json_encode(["message" => "Route created"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    elseif (!empty($_POST['aircraftID']) && !empty($_POST['routeID'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO assignments(aircraftID, routeID) VALUES (?, ?)");
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
    else {
        http_response_code(422);
        echo json_encode(["error" => "Missing required fields"]);
    }
}

else {
    http_response_code(400);
    echo json_encode(["error" => "Unsupported"]);
}
?>
