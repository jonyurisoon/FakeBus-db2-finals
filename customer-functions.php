<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>

<?php

// Create Ticket
function create_ticket($RouteID, $CustomerID)
{
    $db = conn_db();
    $sql = "INSERT INTO Ticket (RouteID, CustomerID) VALUES (?, ?)";
    $st = $db->prepare($sql);

    if ($st->execute([$RouteID, $CustomerID])) {
        // Success - Display SweetAlert
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Ticket booked!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'customerDashboard.php'; // Redirect to the customer dashboard
                }
            });
        </script>";

        // Decrease available seats
        decrease_available_seats($RouteID);
    }
    $db = null;
}

// Function to decrease available seats
function decrease_available_seats($RouteID)
{
    $db = conn_db();
    $sql = "UPDATE Seat SET NumSeatsAvailable = NumSeatsAvailable - 1 WHERE RouteID = ?";
    $st = $db->prepare($sql);
    $st->execute([$RouteID]);
    $db = null;
}



?>