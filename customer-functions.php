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

function bookNow($routeID, $customerID)
{
    $db = conn_db();
    $sql = "INSERT INTO Ticket (RouteID, CustomerID) VALUES (:routeID, :customerID)";
    $st = $db->prepare($sql);
    $st->bindParam(':routeID', $routeID, PDO::PARAM_INT);
    $st->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $st->execute();

    $ticketID = $db->lastInsertId();

    $db = null;

    return $ticketID;
}

function getTicketData($ticketID)
{
    $db = conn_db();

    $sql = "SELECT t.TicketID, t.RouteID, t.CustomerID, r.RouteName, r.DepartureTime, r.ArrivalTime, c.CustomerFName, c.CustomerLName
            FROM Ticket t
            INNER JOIN Route r ON t.RouteID = r.RouteID
            INNER JOIN Customer c ON t.CustomerID = c.CustomerID
            WHERE t.TicketID = ?";

    $st = $db->prepare($sql);
    $st->execute([$ticketID]);
    $ticketData = $st->fetch(PDO::FETCH_ASSOC);

    $db = null;

    return $ticketData;
}
