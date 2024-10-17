<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    // Retrieve form data
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_phone = mysqli_real_escape_string($con, $_POST['user_phone']);
    $user_password = md5($_POST['user_password']); // Encrypting password using md5

    // Check if the email already exists
    $ret = mysqli_query($con, "SELECT user_email FROM tbuser WHERE user_email='$user_email'");
    $result = mysqli_fetch_array($ret);

    if ($result > 0) {
        echo "<script>alert('This email is already associated with another account');</script>";
    } else {
        // Insert the user data into the database
        $query = mysqli_query($con, "INSERT INTO tbuser(user_name, user_email, user_password, user_phone) VALUES('$user_name', '$user_email', '$user_password', '$user_phone')");
        
        if ($query) {
            echo "<script>alert('You have successfully registered');</script>";
            echo "<script>window.location.href ='login.php'</script>";
        } else {
            echo "<script>alert('Something went wrong, please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Art Gallery Management System | Register</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body>
    <form method="post" action="register.php" name="signup">
    <h2>Register Here</h2>         
        <input type="text" name="user_name" placeholder="Enter Name" required>         
        <input type="email" name="user_email" placeholder="Enter Email" required>         
        <input type="password" name="user_password" placeholder="Enter Password" required>         
        <input type="tel" name="user_phone" placeholder="Enter Phone Number" pattern="[0-9]{10}" required>         
        <button type="submit" name="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p> <!-- Added the link to the login page -->   
        <button type="button" class="go-back" onclick="window.location.href='../index.php';">Go Back</button> <!-- Go Back Button -->
    </form>
</body>
</html>
