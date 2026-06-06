<?php
require "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $stmt = $conn->prepare("SELECT * FROM aircraft");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

elseif ($method == "POST") {
    if (empty($_POST['model']) || empty($_POST['capacity']) || empty($_POST['airlineOwnsIt'])) {
        http_response_code(422);
        echo json_encode(["error" => "Model, Capacity and airlineOwnsIt are required"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO aircraft(model, capacity, airlineOwnsIt) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['model'],
            $_POST['capacity'],
            $_POST['airlineOwnsIt']
        ]);
        echo json_encode(["message" => "Aircraft created"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
else {
    http_response_code(400);
    echo json_encode(["error" => "Unsupported method"]);
}
?>
