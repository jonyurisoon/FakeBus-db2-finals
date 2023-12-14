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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 56px;
            /* Height of fixed navbar */
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
        <a class="navbar-brand" href="#">Operator Dashboard</a>
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
                            <a class="nav-link btn btn-info btn-h" href="operatorProfile.php">
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

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addBusModal" style="width:auto; margin-top:5px">
                    &#43; Add Bus
                </button>

                <!-- Add Bus Modal -->
                <div class="modal fade" id="addBusModal" tabindex="-1" role="dialog" aria-labelledby="addBusModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBusModalLabel">Add Bus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Bus name:</label>
                                        <input class="form-control" name="busName" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Bus Number Plate:</label>
                                        <input class="form-control" type="text" name="busPlateNumber" required />
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="submit" style="margin-left: 190px; margin-top: 15px;">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Add Bus Modal -->
                <div>
                    <table class="table table-bordered mx-auto p-2" style="width: 100%; margin-top: 10px;">
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
                            echo "<td class='text-center'>" . $row['BusID'] . "</td>";
                            echo "<td class='text-center'>" . $row['BusName'] . "</td>";
                            echo "<td class='text-center'>" . $row['NumberPlate'] . "</td>";
                            echo "<td class='text-center'>";
                            echo "<table class='table'>";
                            echo "<tr><th>Route Name</th><th>Departure Time</th><th>Number of Seats</th><th>Action</th></tr>";
                            $routes = view_routes($row['BusID']);
                            foreach ($routes as $route) {
                                echo "<tr>";
                                echo "<td class='text-center'>{$route['RouteName']}</td>";
                                echo "<td class='text-center'>{$route['DepartureTime']}</td>";
                                echo "<td class='text-center'>{$route['NumSeatsAvailable']}</td>";
                                echo "<td class='text-center'>";

                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editRouteModal' 
                                data-route-id='{$route['RouteID']}' 
                                data-route-name='{$route['RouteName']}' 
                                data-departure-time='{$route['DepartureTime']}' 
                                data-num-seats-available='{$route['NumSeatsAvailable']}'>Edit</button>&nbsp;";

                                echo "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteRouteModal' 
                                data-route-id='{$route['RouteID']}'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";

                        ?>
                            <?php
                            }
                            echo "</table>";
                            echo "</td>";
                            ?>
                            <td class="justify-content-center text-center">
                                <button class="btn btn-success" data-toggle="modal" data-target="#addRouteModal" data-bus-id="<?php echo $row['BusID']; ?>">Add Route</button>&nbsp;
                                <form method="post" enctype="multipart/form-data" action="?edit_id=<?php echo $row['BusID']; ?>" style="display: inline;">
                                    <input type="hidden" name="edit" value="<?php echo $row['BusID']; ?>">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editBusModal" data-bus-id="<?php echo $row['BusID']; ?>" data-bus-name="<?php echo $row['BusName']; ?>" data-number-plate="<?php echo $row['NumberPlate']; ?>">EDIT</button>&nbsp;
                                </form>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="delete" value="<?php echo $row['BusID']; ?>">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteBusModal" data-bus-id="<?php echo $row['BusID']; ?>">DELETE</button>
                                </form>
                            </td>
                        <?php
                            echo "</tr>";
                        }
                        ?>
                        <!-- Edit Menu Modal -->
                        <div class="modal fade" id="editBusModal" tabindex="-1" role="dialog" aria-labelledby="editBusModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMenuModalLabel">Edit Bus Name</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="BusID" id="edit-bus-id">
                                            <div class="form-group">
                                                <label for="edit-busName">Bus Name</label>
                                                <input type="text" class="form-control" id="edit-busName" name="BusName" required />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-numberPlate">Bus Plate Number</label>
                                                <input type="text" class="form-control" id="edit-numberPlate" name="NumberPlate" required />

                                            </div>
                                            <button class="btn btn-primary" type="submit" name="edit" style="margin-left: 190px; margin-top: 15px;">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Menu Modal -->

                        <!-- Delete Menu Modal -->
                        <div class="modal fade" id="deleteBusModal" tabindex="-1" role="dialog" aria-labelledby="deleteBusModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteBusModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this menu item?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="delete" id="delete-bus-id">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Delete Menu Modal -->

                        <!-- Add Route Modal -->
                        <div class="modal fade" id="addRouteModal" tabindex="-1" role="dialog" aria-labelledby="addRouteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addRouteModalLabel">Add Route</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="BusID" id="route-bus-id">
                                            <div class="form-group">
                                                <label>Route Name:</label>
                                                <input class="form-control" type="text" name="RouteName" required />
                                            </div>
                                            <div class="form-group">
                                                <label>Departure Time:</label>
                                                <input class="form-control" type="datetime-local" name="DepartureTime" required />
                                            </div>
                                            <div class="form-group">
                                                <label>Number of seats: </label>
                                                <input class="form-control" type="number" name="NumSeatsAvailable" required />
                                            </div>
                                            <button class="btn btn-primary" type="submit" name="addRoute" style="margin-left: 190px; margin-top: 15px;">Add Route</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Route Modal -->

                        <!-- Edit Route Modal -->
                        <div class="modal fade" id="editRouteModal" tabindex="-1" role="dialog" aria-labelledby="editRouteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRouteModalLabel">Edit Route</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <input type="hidden" name="editRoute" id="edit-route-id">
                                            <div class="form-group">
                                                <label for="edit-routeName">Route Name:</label>
                                                <input class="form-control" type="text" name="RouteName" id="edit-routeName" required />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-departureTime">Departure Time:</label>
                                                <input class="form-control" type="datetime-local" name="DepartureTime" id="edit-departureTime" required />
                                            </div>
                                            <div class="form-group">
                                                <label for="edit-numSeatsAvailable">Number of seats:</label>
                                                <input class="form-control" type="number" name="NumSeatsAvailable" id="edit-numSeatsAvailable" required />
                                            </div>
                                            <button class="btn btn-primary" type="submit" style="margin-left: 190px; margin-top: 15px;">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Route Modal -->

                        <!-- Delete Route Modal -->
                        <div class="modal fade" id="deleteRouteModal" tabindex="-1" role="dialog" aria-labelledby="deleteRouteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteRouteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this route?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="deleteRoute" id="delete-route-id">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Delete Route Modal -->

            </main>

            <script>
                // Edit Bus Modal
                $('#editBusModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var BusID = button.data('bus-id');
                    var BusName = button.data('bus-name');
                    var NumberPlate = button.data('number-plate');

                    $('#edit-bus-id').val(BusID);
                    $('#edit-busName').val(BusName);
                    $('#edit-numberPlate').val(NumberPlate);
                });

                // Delete Bus Modal
                $('#deleteBusModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var BusID = button.data('bus-id');

                    $('#delete-bus-id').val(BusID);
                });

                // Add Route Modal
                $('#addRouteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var BusID = button.data('bus-id');
                    $('#route-bus-id').val(BusID);
                });

                // Delete Route Modal
                $('#deleteRouteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var RouteId = button.data('route-id');

                    // Set the route ID in the delete modal form
                    $('#delete-route-id').val(RouteId);
                });

                // Edit Route Modal
                $('#editRouteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var RouteId = button.data('route-id');
                    var RouteName = button.data('route-name');
                    var DepartureTime = button.data('departure-time');
                    var NumSeatsAvailable = button.data('num-seats-available');

                    // Populate the modal fields with the route data
                    $('#edit-route-id').val(RouteId);
                    $('#edit-routeName').val(RouteName);
                    $('#edit-departureTime').val(DepartureTime);
                    $('#edit-numSeatsAvailable').val(NumSeatsAvailable);
                });


                // Delete Route Modal
                $('#deleteRouteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var RouteId = button.data('route-id');

                    // Set the route ID in the delete modal form
                    $('#delete-route-id').val(RouteId);
                });
            </script>

        </div>
    </div>
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