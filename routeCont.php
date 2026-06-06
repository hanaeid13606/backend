<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function GetAllRoutes($conn) {
    $routes = GetAllRoutesRepo($conn);
    Response(200, "routes retrieved", $routes);
}

function CreateRoute($conn, $data) {
    if (empty($data['origin']) || empty($data['destination']) || empty($data['distance'])) {
        Response(422, "Origin, Destination and Distance are required");
        return;
    }
    $result = InsertRouteRepo($conn, $data['origin'], $data['destination'], $data['distance']);
    if ($result) {
        Response(201, "Route created");
    } else {
        Response(500, "Error creating route");
    }
}

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