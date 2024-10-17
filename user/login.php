<?php
session_start();
include('includes/dbconnection.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Retrieve form data and check if fields are set
        $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
        $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';

        // Validate that the fields are not empty
        if (!empty($user_email) && !empty($user_password)) {
            // Escape inputs to prevent SQL injection
            $user_email = mysqli_real_escape_string($con, $user_email);

            // Query to check user credentials
            $query = "SELECT user_id, user_name, user_password FROM tbuser WHERE user_email='$user_email'";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                // User exists, fetch user details
                $row = mysqli_fetch_assoc($result);

                // Compare hashed password using md5
                if (md5($user_password) === $row['user_password']) { 
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    // Redirect to user dashboard or homepage
                    header("Location: index.php?user_name=" . urlencode($row['user_name']));
                    exit; // Make sure to exit after header redirection
                } else {
                    echo "<p style='color:red;'>Invalid email or password.</p>";
                }
            } else {
                echo "<p style='color:red;'>Invalid email or password.</p>";
            }
        } else {
            echo "<p style='color:red;'>Please fill in both email and password fields.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="container"> <!-- Container for centering the form -->
        <h2>Login Here</h2>
        <form method="post" action="login.php" name="loginForm">
            <input type="email" name="user_email" required placeholder="Email">
            <input type="password" name="user_password" required placeholder="Password">
            <button type="submit" name="login">Login</button>
        </form>
        <p><a href="forgot_password.php">Forgot Password?</a></p> <!-- Link to the forgot password page -->
        <p>Don't have an account? <a href="register.php">Register here</a></p> <!-- Link to the registration page -->
    </div>
</body>
</html>
