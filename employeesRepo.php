<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getEmployeesByName($conn, $name) {
    if ($name) {
        try {
            $stmt = $conn->prepare("SELECT * FROM employees WHERE name LIKE ?");
            $stmt->execute(["%$name%"]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return $result; 
            } else {
                return ["error" => "No employees found"];
            }
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }
    } else {
        return ["error" => "Name parameter required"];
    }
}
function insertEmployee($conn, $data) {
    try {
        $stmt = $conn->prepare("INSERT INTO employees(name, gender, birthDate, position, airlineWorkedFor) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['name'],
            $data['gender'],
            $data['birthDate'],
            $data['position'],
            $data['airlineWorkedFor']
        ]);
        return ["message" => "Employee created"];
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}
?>
