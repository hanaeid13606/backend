<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path   = $_SERVER['PATH_INFO'] ?? '/';

if ($method == "GET" && $path == "/transactions") {
    getAllTransactions($conn);
}
elseif ($method == "POST" && $path == "/transactions") {
    createTransaction($conn, $_POST);
}
else {
    http_response_code(404);
    jsonResponse(["error" => "Route not found"], 404);
}
?>
