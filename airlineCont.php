<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function GetEmployeesAndAirlines($conn, $name) {
    if ($name) {
        $employees = GetEmployeesByName($conn, $name);
        $airlines  = GetAirlinesByName($conn, $name);

        if ($employees || $airlines) {
            Response(200, "results retrieved", [
                "employees" => $employees,
                "airlines"  => $airlines
            ]);
        } else {
            Response(404, "No employees or airlines found");
        }
    } else {
        $employees = GetAllEmployees($conn);
        Response(200, "employees retrieved", $employees);
    }
}

function CreateEmployee($conn, $data) {
    if (empty($data['name']) || empty($data['gender']) || empty($data['birthDate']) || empty($data['position']) || empty($data['airlineWorkedFor'])) {
        Response(422, "All fields are required");
        return;
    }
    $result = InsertEmployee($conn, $data);
    if ($result) {
        Response(201, "Employee created");
    } else {
        Response(500, "Error creating employee");
    }
}

function DeleteAirline($conn, $name) {
    if (!$name) {
        Response(400, "name parameter required");
        return;
    }
    $result = DeleteAirline($conn, $name);
    if ($result) {
        Response(200, "Airline deleted");
    } else {
        Response(500, "Error deleting airline");
    }
}

function UpdateAirline($conn, $id, $name) {
    if (!$id || !$name) {
        Response(400, "Missing required fields");
        return;
    }
    $result = UpdateAirline($conn, $id, $name);
    if ($result) {
        Response(200, "Airline updated successfully");
    } else {
        Response(500, "Failed to update airline");
    }
}
?>

