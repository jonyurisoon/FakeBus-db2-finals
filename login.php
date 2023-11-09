<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="css/styles-login.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>

<body>
    <?php
    include 'loginFunction.php'
    ?>
    <div class="container mt-5">
        <div class="login-container mx-auto p-4 border rounded shadow mb-5 bg-white">
            <img src="img/logo.png" alt="Login Photo" class="img-fluid mx-auto d-block mb-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="userType">User Type:</label>
                    <select class="form-control" id="userType" name="userType" autocomplete="off">
                        <option value="Customer">Customer</option>
                        <option value="Operator">Operator</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                </div>
                <p class="mt-3">Don't have an account? <a href="register.php">Click here</a></p>
                <button type="submit" class="btn btn-primary mx-auto d-block">Login</button>

            </form>
        </div>
</body>

</html>