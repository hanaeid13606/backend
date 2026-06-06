<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path   = $_SERVER['PATH_INFO'] ?? '/';

if ($method == "GET" && $path == "/routes") {
    getAllRoutes($conn);
}
elseif ($method == "POST" && $path == "/routes") {
    if (!empty($_POST['origin']) && !empty($_POST['destination']) && !empty($_POST['distance'])) {
        createRoute($conn, $_POST);
    } else {
        http_response_code(422);
        echo json_encode(["error" => "Origin, Destination and Distance are required"]);
    }
}
elseif ($method == "POST" && $path == "/assign-route") {
    if (!empty($_POST['aircraftID']) && !empty($_POST['routeID'])) {
        assignAircraftToRoute($conn, $_POST);
    } else {
        http_response_code(422);
        echo json_encode(["error" => "aircraftID and routeID are required"]);
    }
}
else {
    http_response_code(404);
    echo json_encode(["error" => "Route not found"]);
}
?>
