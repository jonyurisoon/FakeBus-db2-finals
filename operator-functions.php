<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>

<?php

function conn_db()
{
    try {
        //if not working, change '3306' to your mysql port
        return new PDO('mysql:host=localhost:3306;dbname=BUS_DB2', 'root', '');
    } catch (PDOException $ex) {
        echo "Connection Error: ", $ex->getMessage();
    }
}

//Create
function add_data($BusName, $NumberPlate)
{
    $db = conn_db();
    $sql = "INSERT INTO Bus(BusName, NumberPlate) values(?, ?)";
    $st = $db->prepare($sql);

    if ($st->execute(array($BusName, $NumberPlate))) {
        // Success - Display SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Bus created!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php'; // Redirect to the main page
                }
            });
        </script>";
    }
    $db = null;
}

// Retrieve 
function view_data()
{
    $db = conn_db();
    $sql = "SELECT * FROM Bus ORDER BY BusID ASC";
    $st = $db->prepare($sql);
    $st->execute();
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    return $rows;
}

/* Retrieve JSON format
function view_data_json()
{
    $db = conn_db();
    $sql = "SELECT * FROM Bus ORDER BY BusID ASC";
    $st = $db->prepare($sql);
    $st->execute();
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
    $jsonRes = json_encode($rows);
    echo $jsonRes;
    $db = null;
    return $rows;
}
*/

// Update bus
function update_data($BusName, $NumberPlate, $BusID)
{
    $db = conn_db();
    $sql = "UPDATE Bus SET BusName=?, NumberPlate=? WHERE BusID=?";
    $st = $db->prepare($sql);

    if ($st->execute([$BusName, $NumberPlate, $BusID])) {
        // Success - Display SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Bus updated!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php'; // Redirect to the main page
                }
            });
        </script>";
    }
    $db = null;
}

// Delete bus
function delete_data($BusID)
{
    $db = conn_db();
    $sql = "DELETE FROM Bus WHERE BusID=?";
    $st = $db->prepare($sql);

    if ($st->execute([$BusID])) {
        // Success - Display SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Bus deleted!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php'; // Redirect to the main page
                }
            });
        </script>";
    }
    $db = null;
}

//Search
function search_data($BusID)
{
    $db = conn_db();
    $sql = "SELECT * FROM Bus WHERE BusID=?";
    $st = $db->prepare($sql);
    $st->execute(array($BusID));
    $row = $st->fetch(PDO::FETCH_ASSOC);
    $db = null;
    return $row ?: [];
}

function add_route($BusID, $RouteName, $DepartureTime, $ArrivalTime, $NumSeatsAvailable)
{
    // Validate that ArrivalTime is greater than DepartureTime
    if (strtotime($ArrivalTime) <= strtotime($DepartureTime)) {
        // Display an error message and reopen the modal with the form data
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ArrivalTime must be greater than DepartureTime!',
            }).then(() => {
                // Reopen the modal with the form data
                $('#addRouteModal').modal('show');
                // Populate the form fields
                $('#route-bus-id').val('$BusID');
                $('input[name=RouteName]').val('$RouteName');
                $('input[name=DepartureTime]').val('$DepartureTime');
                $('input[name=ArrivalTime]').val('$ArrivalTime');
                $('input[name=NumSeatsAvailable]').val('$NumSeatsAvailable');
            });
        </script>";
        return; // Exit the function if the condition is not met
    }

    $db = conn_db();
    $sql = "INSERT INTO Route (BusID, RouteName, ArrivalTime, DepartureTime) VALUES (?, ?, ?, ?)";
    $st = $db->prepare($sql);

    if ($st->execute([$BusID, $RouteName, $ArrivalTime, $DepartureTime])) {
        // Get the last inserted route ID
        $routeID = $db->lastInsertId();

        // Insert NumSeatsAvailable into the seat table if it's not NULL
        if ($NumSeatsAvailable !== NULL) {
            add_seats($routeID, $NumSeatsAvailable);
        }

        // Display success message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Route added!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php';
                }
            });
        </script>";
    }
    $db = null;
}


function view_routes($BusID)
{
    $db = conn_db();
    $sql = "SELECT r.RouteID, r.RouteName, r.DepartureTime, r.ArrivalTime, s.NumSeatsAvailable 
            FROM Route r
            LEFT JOIN Seat s ON r.RouteID = s.RouteID
            WHERE r.BusID = ?
            ORDER BY r.RouteID ASC";
    $st = $db->prepare($sql);
    $st->execute([$BusID]);
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    return $rows;
}


function update_route($RouteName, $DepartureTime, $ArrivalTime, $NumSeatsAvailable, $RouteID)
{
    $db = conn_db();

    // Update route details
    $sqlUpdateRoute = "UPDATE Route SET RouteName=?, ArrivalTime=?, DepartureTime=? WHERE RouteID=?";
    $stUpdateRoute = $db->prepare($sqlUpdateRoute);

    if ($stUpdateRoute->execute([$RouteName, $DepartureTime, $ArrivalTime, $RouteID])) {
        // Success - Update NumSeatsAvailable in associated seats
        update_seats($RouteID, $NumSeatsAvailable);

        // Display success message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Route updated!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php';
                }
            });
        </script>";
    }

    $db = null;
}

// Example of deleting related seats before deleting the route with SweetAlert
function delete_route($RouteID)
{
    $db = conn_db();

    $sqlDeleteSeats = "DELETE FROM seat WHERE RouteID = ?";
    $stDeleteSeats = $db->prepare($sqlDeleteSeats);
    $stDeleteSeats->execute([$RouteID]);

    $sqlDeleteRoute = "DELETE FROM route WHERE RouteID = ?";
    $stDeleteRoute = $db->prepare($sqlDeleteRoute);

    if ($stDeleteRoute->execute([$RouteID])) {
        // Success message with SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Route deleted!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'operatorDashboard.php';
                }
            });
        </script>";
    }

    $db = null;
}

function add_seats($routeID, $numSeatsAvailable)
{
    $db = conn_db();
    $sql = "INSERT INTO seat (RouteID, NumSeatsAvailable) VALUES (?, ?)";
    $st = $db->prepare($sql);

    $st->execute([$routeID, $numSeatsAvailable]);

    $db = null;
}

function update_seats($RouteID, $NumSeatsAvailable)
{
    $db = conn_db();

    // Update NumSeatsAvailable in seats table
    $sqlUpdateSeats = "UPDATE seat SET NumSeatsAvailable=? WHERE RouteID=?";
    $stUpdateSeats = $db->prepare($sqlUpdateSeats);

    $stUpdateSeats->execute([$NumSeatsAvailable, $RouteID]);

    $db = null;
}
