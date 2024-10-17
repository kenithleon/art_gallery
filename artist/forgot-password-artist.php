<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];

    // Query to check artist details
    $query = mysqli_query($con, "SELECT ID FROM tblartist WHERE Email='$email' AND MobileNumber='$contactno'");
    $ret = mysqli_fetch_array($query);
    
    if ($ret > 0) {
        $_SESSION['contactno'] = $contactno;
        $_SESSION['email'] = $email;
        echo "<script type='text/javascript'> document.location ='reset-password-artist.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password | Art Gallery Management System</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/style3.css" rel="stylesheet">
</head>
<body class="login-img3-body">
    <div class="container">
        <form class="login-form" action="" method="post">
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_profile"></i></span>
                    <input type="text" class="form-control" name="email" placeholder="Email" autofocus required="true">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="text" class="form-control" name="contactno" placeholder="Mobile Number" required="true">
                </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Reset</button>
                <span class="pull-right"><a href="artlogin.php"> Sign In</a></span>
            </div>
        </form>
    </div>
</body>
</html>
