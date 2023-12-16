<?php
include 'operator-crud.php';

if (isset($_POST['bookNow'])) {
    $BusID = $_POST['BusID'];
    $RouteID = $_POST['RouteID'];

    // Insert into Ticket table
    add_ticket($RouteID);

    // Redirect to bookTicket.php with the RouteID as a parameter
    header("Location: customerProfile.php?RouteID=$RouteID");
    exit();
}
if (isset($_GET['RouteID'])) {
    $RouteID = $_GET['RouteID'];

    // Retrieve booked ticket information
    $bookedRoute = get_booked_route($RouteID);
} else {
    // If RouteID is not set, handle the error or redirect as needed
    header("Location: errorPage.php");
    exit();
}

function add_ticket($RouteID)
{
    $db = conn_db();
    $sql = "INSERT INTO Ticket (RouteID) VALUES (?)";
    $st = $db->prepare($sql);

    if ($st->execute([$RouteID])) {
        // Success - You may add additional logic here if needed
    }
    $db = null;
}
function get_booked_route($RouteID)
{
    $db = conn_db();
    $sql = "SELECT r.RouteID, r.RouteName, r.DepartureTime, r.ArrivalTime, s.NumSeatsAvailable, b.BusName
            FROM Route r
            LEFT JOIN Seat s ON r.RouteID = s.RouteID
            LEFT JOIN Bus b ON r.BusID = b.BusID
            WHERE r.RouteID = ?";
    $st = $db->prepare($sql);
    $st->execute([$RouteID]);
    $bookedRoute = $st->fetch(PDO::FETCH_ASSOC);
    $db = null;
    return $bookedRoute ?: [];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 56px;
        }

        .logout-btn {
            width: 90%;
            position: absolute;
            bottom: 20px;
        }

        .btn-h {
            margin-top: 20px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            padding-top: 56px;
        }

        .main-content {
            margin-left: 200px;
            padding: 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Customer Dashboard</a>
        <form class="form-inline my-2 my-lg-0 ml-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchData()">Search</button>
        </form>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-info btn-h">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-info btn-h" href="customerProfile.php">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-info btn-h" href="settings.php">
                                Settings
                            </a>
                        </li>
                    </ul>
                    <button class="btn btn-danger btn-sm logout-btn" onclick="confirmLogout()">Logout</button>
                </div>
            </nav>

            <div class="container text-center">
                <h1 class="mt-5">Booked Ticket Information</h1>

                <?php if (!empty($bookedRoute)) : ?>
                    <table id="customerTable" class="table table-bordered mx-auto p-2" style="width: 60%; margin-top: 80px;">
                        <tr>
                            <th style="text-align: center;">Route ID</th>
                            <th style="text-align: center;">Bus Name</th>
                            <th style="text-align: center;">Route Name</th>
                            <th style="text-align: center;">Departure Time</th>
                            <th style="text-align: center;">Arrival Time</th>
                            <th style="text-align: center;">Action</th>
                        <tr>
                            <td style="text-align: center;"><?php echo $bookedRoute['RouteID']; ?></td>
                            <td style="text-align: center;"><?php echo $bookedRoute['BusName']; ?></td>
                            <td style="text-align: center;"><?php echo $bookedRoute['RouteName']; ?></td>
                            <td style="text-align: center;"><?php echo $bookedRoute['DepartureTime']; ?></td>
                            <td style="text-align: center;"><?php echo $bookedRoute['ArrivalTime']; ?></td>
                            <td><button class="btn btn btn-success" type="submit" name="payment">Pay Now</button></td>
                        </tr>
                    </table>
                <?php else : ?>
                    <p>No booked ticket information available.</p>
                <?php endif; ?>
            </div>
</body>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Display a confirmation alert after successful logout
                Swal.fire({
                    title: 'Logged Out',
                    text: 'You have successfully logged out.',
                    icon: 'success'
                }).then(() => {
                    // Redirect to the login page after logout confirmation
                    window.location.href = "login.php";
                });
            }
        });
    }
</script>

</html>