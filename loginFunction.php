<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $sql = '';
        if ($userType == "Customer") {
            $sql = "SELECT * FROM Customer WHERE CustomerEmail=?";
        } elseif ($userType == "Operator") {
            $sql = "SELECT * FROM BusOperator WHERE OperatorEmail=?";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $passwordColumn = $userType . "Password";
            if (password_verify($password, $row[$passwordColumn])) {
                // Successful login
                echo '<script type="text/javascript">';
                echo 'Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Login successful.",
                    }).then(() => {';

                // Redirect based on user type
                if ($userType == "Customer") {
                    echo 'window.location.href = "customerDashboard.php";';
                } elseif ($userType == "Operator") {
                    echo 'window.location.href = "operatorDashboard.php";';
                }

                echo '});';
                echo '</script>';
            } else {
                // Invalid credentials
                echo '<script type="text/javascript">';
                echo 'Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Invalid credentials.",
                    });';
                echo '</script>';
            }
        } else {
            // Invalid credentials
            echo '<script type="text/javascript">';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Oops!",
                    text: "Invalid credentials.",
                });';
            echo '</script>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>

</html>