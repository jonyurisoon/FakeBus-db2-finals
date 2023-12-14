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


?>