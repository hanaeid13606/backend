<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function AssignAircraftToRoute($conn, $data) {
    if (empty($data['aircraftID']) || empty($data['routeID'])) {
        Response(422, "aircraftID and routeID are required");
        return;
    }

    $result = InsertAssignment($conn, $data['aircraftID'], $data['routeID']);
    if ($result) {
        Response(201, "Aircraft assigned to route");
    } else {
        Response(500, "Error assigning aircraft");
    }
}
?>