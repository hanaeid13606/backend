<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path   = $_SERVER['PATH_INFO'] ?? '/';

if ($method == "POST" && $path == "/assignments") {
    createAssignment($conn, $_POST);
}
else {
    http_response_code(404);
    echo json_encode(["error" => "Route not found"]);
}
?>
