<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path   = $_SERVER['PATH_INFO'] ?? '/';

if ($method == "GET" && $path == "/employees") {
    if (isset($_GET['name'])) {
        getEmployeesAndAirlineByName($conn, $_GET['name']);
    } else {
        getAllEmployees($conn);
    }
}
elseif ($method == "POST" && $path == "/employees") {
    createEmployee($conn, $_POST);
}
elseif ($method == "DELETE" && $path == "/airline") {
    if (isset($_GET['name'])) {
        deleteAirline($conn, $_GET['name']);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "name parameter required"]);
    }
}
elseif ($method == "PATCH" && $path == "/airline") {
    if (isset($_POST['id']) && isset($_POST['name'])) {
        updateAirline($conn, $_POST['id'], $_POST['name']);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields"]);
    }
}
else {
    http_response_code(404);
    echo json_encode(["error" => "Route not found"]);
}
?>
