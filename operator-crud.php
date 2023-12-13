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

// Add Route
if (isset($_POST['addRoute'])) {
    $BusID = isset($_POST['BusID']) ? trim($_POST['BusID']) : '';
    $RouteName = isset($_POST['RouteName']) ? trim($_POST['RouteName']) : '';
    $DepartureTime = isset($_POST['DepartureTime']) ? trim($_POST['DepartureTime']) : '';
    $NumSeatsAvailable = isset($_POST['NumSeatsAvailable']) ? trim($_POST['NumSeatsAvailable']) : 0;

    add_route($BusID, $RouteName, $DepartureTime, $NumSeatsAvailable);
}

// Edit Route
if (isset($_POST['editRoute'])) {
    $RouteID = trim($_POST['editRoute']);
    $RouteName = trim($_POST['RouteName']);
    $DepartureTime = trim($_POST['DepartureTime']);
    $NumSeatsAvailable = trim($_POST['NumSeatsAvailable']);

    update_route($RouteName, $DepartureTime, $NumSeatsAvailable, $RouteID);
}


// Delete Route
if (isset($_POST['deleteRoute'])) {
    $RouteID = trim($_POST['deleteRoute']);
    delete_route($RouteID);
}
