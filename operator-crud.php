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
