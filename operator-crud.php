<?php
include 'operator-functions.php';

if (isset($_POST['submit'])) {
    $BusName = isset($_POST['busName']) ? trim($_POST['busName']) : '';
    $NumberPlate = isset($_POST['busPlateNumber']) ? trim($_POST['busPlateNumber']) : '';

    add_data($BusName, $NumberPlate);
}

if (isset($_POST['edit'])) {
    $BusID = trim($_POST['BusID']);
    $BusName = trim($_POST['BusName']);
    $NumberPlate = trim($_POST['NumberPlate']);

    update_data($BusName, $NumberPlate, $BusID);
}

if (isset($_POST['delete'])) {
    $BusID = trim($_POST['delete']);
    delete_data($BusID);
}

if (isset($_POST['addRoute'])) {
    $BusID = isset($_POST['BusID']) ? trim($_POST['BusID']) : '';
    $RouteName = isset($_POST['RouteName']) ? trim($_POST['RouteName']) : '';
    $DepartureTime = isset($_POST['DepartureTime']) ? trim($_POST['DepartureTime']) : '';

    add_route($BusID, $RouteName, $DepartureTime);
}

// Edit Route
if (isset($_POST['editRoute'])) {
    $RouteID = trim($_POST['editRoute']);  // Corrected variable name
    $RouteName = trim($_POST['RouteName']);
    $DepartureTime = trim($_POST['DepartureTime']);

    update_route($RouteName, $DepartureTime, $RouteID);  // Corrected parameter order
}

// Delete Route
if (isset($_POST['deleteRoute'])) {
    $routeID = $_POST['deleteRoute'];

    delete_route($routeID);
}
