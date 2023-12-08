<!DOCTYPE html>
<html lang="en">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "BUS_DB2";

        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $userType = isset($_POST['userType']) ? $_POST['userType'] : '';
        $fName = isset($_POST['fName']) ? $_POST['fName'] : '';
        $lName = isset($_POST['lName']) ? $_POST['lName'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phoneNum = isset($_POST['phoneNum']) ? $_POST['phoneNum'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if passwords match
        if ($password !== $confirmPassword) {
            // Display error if passwords do not match.
            echo '<script type="text/javascript">';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Oops!",
                    text: "Passwords do not match. Please enter matching passwords.",
                });';
            echo '</script>';
        } else {
            // Check password complexity
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/', $password)) {
                // Display error if password complexity requirements are not met.
                echo '<script type="text/javascript">';
                echo 'Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Password must contain at least one uppercase letter, one number, and one special character.",
                    });';
                echo '</script>';
            } else {
                $checkEmailQuery = "";
                if ($userType == "Customer") {
                    $checkEmailQuery = "SELECT * FROM Customer WHERE CustomerEmail='$email'";
                } elseif ($userType == "Operator") {
                    $checkEmailQuery = "SELECT * FROM BusOperator WHERE OperatorEmail='$email'";
                }

                $result = $conn->query($checkEmailQuery);

                if ($result->num_rows > 0) {
                    // Email not available. Display SweetAlert.
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Email is already registered!. Please choose another email.",
                    });';
                    echo '</script>';
                } else {
                    if ($userType == "Customer") {
                        $insertQuery = "INSERT INTO Customer (CustomerFName, CustomerLName, CustomerEmail, CustomerPhoneNum, CustomerPassword)
                                VALUES ('$fName', '$lName', '$email', '$phoneNum', '$hashedPassword')";
                    } elseif ($userType == "Operator") {
                        $insertQuery = "INSERT INTO BusOperator (OperatorFName, OperatorLName, OperatorEmail, OperatorPhoneNum, OperatorPassword)
                                VALUES ('$fName', '$lName', '$email', '$phoneNum', '$hashedPassword')";
                    }

                    if ($conn->query($insertQuery) === TRUE) {
                        // Registration successful. Display SweetAlert.
                        echo '<script type="text/javascript">';
                        echo 'Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Registration successful!",
                        }).then(() => {
                            window.location.href = "login.php";
                        })';
                        echo '</script>';
                    } else {
                        // Display error if registration fails.
                        echo "Error: " . $conn->error;
                    }
                }
            }

            // Close connection
            $conn->close();
        }
    }

    ?>
</body>

</html>