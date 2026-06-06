<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function getByEmpName($conn, $name) {
    if ($name) {
        $stmtEmp = $conn->prepare("SELECT * FROM employees WHERE name LIKE ?");
        $stmtEmp->execute(["%$name%"]);
        $employees = $stmtEmp->fetchAll(PDO::FETCH_ASSOC);

        $stmtAir = $conn->prepare("SELECT * FROM airline WHERE name LIKE ?");
        $stmtAir->execute(["%$name%"]);
        $airline = $stmtAir->fetchAll(PDO::FETCH_ASSOC);

        return ($employees || $airline)
            ? ["employees" => $employees, "airline" => $airline]
            : ["error" => "No employees or airlines found"];
    } else {
        $stmt = $conn->prepare("SELECT * FROM employees");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

function insertEmployee($conn, $data) {
    try {
        $stmt = $conn->prepare("INSERT INTO employees(name,gender,birthDate,position,airlineWorkedFor) 
                                VALUES(?,?,?,?,?)");
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

