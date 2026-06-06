<?php
require "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    if (isset($_GET['name'])) {
        $name = $_GET['name'];

        $stmt = $conn->prepare("SELECT * FROM employees WHERE name LIKE ?");
        $stmt->execute(["%$name%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No employees found"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Name parameter required"]);
    }
}

if ($method == "POST") {
    if (empty($_POST['name'])) {
        http_response_code(422);
        echo json_encode(["error" => "Name is required"]);
        exit;
    }
    if (empty($_POST['gender'])) {
        http_response_code(422);
        echo json_encode(["error" => "Gender is required"]);
        exit;
    }
    if (empty($_POST['birthDate'])) {
        http_response_code(422);
        echo json_encode(["error" => "BirthDate is required"]);
        exit;
    }
    if (empty($_POST['position'])) {
        http_response_code(422);
        echo json_encode(["error" => "Position is required"]);
        exit;
    }
    if (empty($_POST['airlineWorkedFor'])) {
        http_response_code(422);
        echo json_encode(["error" => "AirlineWorkedFor is required"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO employees(name, gender, birthDate, position, airlineWorkedFor) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['gender'],
            $_POST['birthDate'],
            $_POST['position'],
            $_POST['airlineWorkedFor']
        ]);
        echo json_encode(["message" => "Employee created"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
