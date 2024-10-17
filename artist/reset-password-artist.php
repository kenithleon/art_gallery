<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $contactno = $_SESSION['contactno'];
    $email = $_SESSION['email'];
    $password = md5($_POST['newpassword']); // Hash the new password

    // Update query for tblartist
    $query = mysqli_query($con, "UPDATE tblartist SET Password='$password' WHERE Email='$email' AND MobileNumber='$contactno'");

    if ($query) {
        echo "<script>alert('Password successfully changed');</script>";
        session_destroy(); // Destroy session after password change
        echo "<script type='text/javascript'> document.location ='artlogin.php'; </script>"; // Redirect to login page
    } else {
        echo "<script>alert('Failed to change password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password | Art Gallery Management System</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/style4.css" rel="stylesheet">
    <script type="text/javascript">
        function checkpass() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password field does not match');
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="login-img3-body">
    <div class="container">
        <form class="login-form" action="" method="post" name="changepassword" onsubmit="return checkpass();">
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" class="form-control" name="newpassword" placeholder="New Password" required="true">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required="true">
                </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Reset</button>
                <span class="pull-right"><a href="artlogin.php"> Sign In</a></span>
            </div>
        </form>
    </div>
</body>
</html>
