<?php
include 'customer-functions.php';

// Handle form submission for booking
if (isset($_POST['bookNowSubmit'])) {
    // Assuming you have form validation here

    $routeID = $_POST['routeID'];
    $customerID = $_POST['customerID'];

    // Perform the database insert for the ticket
    $ticketID = bookNow($routeID, $customerID);

    // Optionally, you can redirect or display a success message
    header('Location: payment.php');
    exit;
}


// Retrieve ticketID from URL parameters
$ticketID = isset($_GET['ticketID']) ? $_GET['ticketID'] : null;

// Validate and sanitize the ticketID if needed

// Fetch data related to the ticketID from the database
$ticketData = getTicketData($ticketID);

// Display the payment information
if ($ticketData) {
    echo "Payment Details for Ticket ID: {$ticketData['TicketID']}<br>";
    echo "Route Name: {$ticketData['RouteName']}<br>";
    echo "Departure Time: {$ticketData['DepartureTime']}<br>";
    echo "Arrival Time: {$ticketData['ArrivalTime']}<br>";
    echo "Customer Name: {$ticketData['CustomerFName']} {$ticketData['CustomerLName']}<br>";
    // Display other relevant information
} else {
    echo "Invalid Ticket ID or Ticket not found.";
}
