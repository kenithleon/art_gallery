<?php
session_start();
include('includes/dbconnection.php'); // Make sure this file connects to your database

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password for security
    $education = $_POST['education'];
    $award = $_POST['award'];
    $profilepic = $_FILES['profilepic']['name'];
    $tmp_name = $_FILES['profilepic']['tmp_name'];

    // Moving the uploaded profile picture to the "images" directory
    move_uploaded_file($tmp_name, "images/" . $profilepic);

    // Check if the email is already registered
    $query = mysqli_query($con, "SELECT Email FROM tblartist WHERE Email='$email'");
    $result = mysqli_fetch_array($query);

    if ($result) {
        echo "<script>alert('This email is already registered. Please try another email.');</script>";
    } else {
        $query = mysqli_query($con, "INSERT INTO tblartist(Name, MobileNumber, Email, Password, Education, Award, Profilepic) 
                                     VALUES('$name', '$mobile', '$email', '$password', '$education', '$award', '$profilepic')");
        if ($query) {
            // Display success message with "Go Back" button
            echo "<script>alert('You have successfully registered!');</script>";
            echo "<script>window.location.href='artlogin.php';</script>"; // Redirect to a success page
        } else {
            echo "<script>alert('Something went wrong. Please try again later.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Artist Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container"> <!-- Container for the form -->
        <h2>Artist Registration</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" placeholder="Enter your full name" required>

            <label>Mobile Number:</label>
            <input type="text" name="mobile" placeholder="Enter your mobile number" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your email address" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <label>Education:</label>
            <textarea name="education" placeholder="Describe your education" required></textarea>

            <label>Award:</label>
            <textarea name="award" placeholder="List any awards received" required></textarea>

            <label>Profile Picture:</label>
            <input type="file" name="profilepic" required>

            <input type="submit" name="submit" value="Register">
        </form>
    </div>
</body>
</html>
