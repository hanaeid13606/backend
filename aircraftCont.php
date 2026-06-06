<?php
require __DIR__ . "/../connection.php";
require __DIR__ . "/../respone.php";
require __DIR__ . "/../validator.php";

function GetAllAircraft($conn) {
    $aircraft = GetAllAircraft($conn);
    Response(200, "aircraft retrieved", $aircraft);
}

function CreateAircraft($conn) {
    if (empty($_POST['model']) || empty($_POST['capacity']) || empty($_POST['airlineOwnsIt'])) {
        Response(422, "Model, Capacity and airlineOwnsIt are required");
        return;
    }
    $result = InsertAircraft($conn, $_POST['model'], $_POST['capacity'], $_POST['airlineOwnsIt']);
    if ($result) {
        Response(201, "Aircraft created");
    } else {
        Response(500, "Error creating aircraft");
    }
}
?>
