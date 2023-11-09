<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles-register.css">

</head>

<body>
    <?php
    include 'registerFunction.php'
    ?>
    <div class="custom-container border rounded p-4 shadow mb-5 bg-white">
        <img src="img/logo.png" alt="Login Photo" class="img-fluid mx-auto d-block mb-4">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="userType">User Type:</label>
                <select class="form-control" name="userType" required>
                    <option value="Customer">Customer</option>
                    <option value="Operator">Operator</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fName">First Name:</label>
                <input type="text" class="form-control" name="fName" required>
            </div>

            <div class="form-group">
                <label for="lName">Last Name:</label>
                <input type="text" class="form-control" name="lName" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-group">
                <label for="phoneNum">Phone Number:</label>
                <input type="text" class="form-control" name="phoneNum" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" class="form-control" name="confirmPassword" required>
            </div>

            <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
            <button type="submit" class="btn btn-primary mx-auto d-block">Register</button>
        </form>
    </div>

</body>

</html>