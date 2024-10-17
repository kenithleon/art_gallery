<?php
session_start(); // Start the session

// Perform logout actions
if (isset($_SESSION['user_id'])) {
    // Unset session variables
    unset($_SESSION['user_id']);
    session_destroy(); // Destroy the session
}

// Redirect to the index page outside of the user module
header("Location: ../index.php"); // Adjust the path according to your folder structure
exit(); // Ensure no further code is executed
?>
