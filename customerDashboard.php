<?php
include 'operator-crud.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Dashboard</title>
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
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-info btn-h" href="#">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-info btn-h" href="#">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-info btn-h" href="#">
                                Settings
                            </a>
                        </li>
                    </ul>
                    <button class="btn btn-danger btn-sm logout-btn" onclick="confirmLogout()">Logout</button>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <div>
                    <table class="table table-bordered table-hover mx-auto p-2" style="width: 100%; margin-top: 10px;">
                        <tr>
                            <td style="text-align: center;"><b>ID</b></td>
                            <td style="text-align: center;"><b>BUS NAME</b></td>
                            <td style="text-align: center;"><b>BUS PLATE NUMBER</b></td>
                            <td style="text-align: center;"><b>ROUTES</b></td>
                            <td style="text-align: center;"><b>ACTION</b></td>
                        </tr>
                        <?php
                        $rows = view_data();
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['BusID'] . "</td>";
                            echo "<td>" . $row['BusName'] . "</td>";
                            echo "<td>" . $row['NumberPlate'] . "</td>";

                            echo "<td>";
                            echo "<table class='table'>";
                            echo "<tr><th>Route Name</th><th>Departure Time</th></tr>";
                            $routes = view_routes($row['BusID']);
                            foreach ($routes as $route) {
                                echo "<tr><td>{$route['RouteName']}</td><td>{$route['DepartureTime']}</td></tr>";
                            }
                            echo "</table>";
                            echo "</td>";
                        ?>
                        <?php echo "</tr>";
                        }
                        ?>
            </main>
        </div>
    </div>

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
</body>

</html>