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
    $sql = "Insert into Bus(BusName, NumberPlate) values(?, ?)";
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

//Update
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

//Delete
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
