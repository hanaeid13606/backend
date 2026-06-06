<?php
require "connection.php";
require "helpers/response.php";
require "helpers/validator.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    if (isset($_GET['name'])) {
        $name = $_GET['name'];

        $stmtEmp = $conn->prepare("SELECT * FROM employees WHERE name LIKE ?");
        $stmtEmp->execute(["%$name%"]);
        $employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);

        $stmtAir = $conn->prepare("SELECT * FROM airline WHERE name LIKE ?");
        $stmtAir->execute(["%$name%"]);
        $airline = $stmtAir->fetchAll(PDO::FETCH_ASSOC);

        if ($employees || $airline) {
            echo json_encode([
                "employees" => $employees,
                "airline" => $airline
            ]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No employees or airlines found"]);
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM employees");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}

if ($method == "POST") {
    if (empty($_POST['name']) || empty($_POST['gender']) || empty($_POST['birthDate']) || empty($_POST['position']) || empty($_POST['airlineWorkedFor'])) {
        http_response_code(422);
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO employees(name,gender,birthDate,position,airlineWorkedFor) 
                                VALUES(?,?,?,?,?)");
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

if ($method == "DELETE") {
    if (isset($_GET['name'])) {
        $stmt = $conn->prepare("DELETE FROM airline WHERE name = ?");
        $stmt->execute([$_GET['name']]);
        echo json_encode(["message" => "Airline deleted"]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "name parameter required"]);
    }
}

if ($method == "PATCH") {
    if (isset($_POST['id']) && isset($_POST['name'])) {
        $stmt = $conn->prepare("UPDATE airline SET name = ? WHERE id = ?");
        if ($stmt->execute([$_POST['name'], $_POST['id']])) {
            echo json_encode(["message" => "Airline updated successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to update airline"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields"]);
    }
}
?>

