<?php
session_start();

include('../includes/dbconnection.php'); // Ensure this file connects to your database

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password to match stored hash

    $query = mysqli_query($con, "SELECT ID, Name FROM tblartist WHERE Email='$email' AND Password='$password'");
    $result = mysqli_fetch_array($query);

    if ($result > 0) {
        $_SESSION['artist_id'] = $result['ID'];
        $_SESSION['artist_name'] = $result['Name'];
        echo "<script>alert('Login successful!');</script>";
        echo "<script>window.location.href='artist_dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Artist Login</title>
    <style>
        body {
            background: linear-gradient(to right, #a8c0ff, #3f2b96);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        h2 {
            color: #6a5acd;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(106, 90, 205, 0.8);
            position: relative;
            z-index: 1;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: #333;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            transition: border 0.3s ease;
            position: relative;
            z-index: 1;
        }

        input[type="submit"] {
            background-color: #6a5acd;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s;
            position: relative;
            z-index: 1;
        }

        .go-back-button {
            background-color: #f0f0f0;
            color: #333;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
            width: 100%;
            text-align: center;
        }

        p {
            margin-top: 15px;
            color: #333; /* Changed to dark text */
            position: relative;
            z-index: 1;
        }

        a {
            color: #6a5acd;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Artist Login</h2>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="login" value="Login">
        </form>

        <p><a href="forgot-password-artist.php">Forget Password?</a></p>
        <button type="button" class="go-back-button" onclick="window.location.href='../index.php';">Go Back</button>
        <p>Are you a new user? <a href="artregister.php">Register here</a></p>
    </div>
</body>
</html>
