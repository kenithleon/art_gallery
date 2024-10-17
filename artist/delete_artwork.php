<?php
// Include your database connection file
include('includes/dbconnection.php'); // Make sure to update this with the correct path to your database connection file

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $artwork_id = intval($_GET['id']); // Get the artwork ID from the URL and convert it to an integer

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM tblartproduct WHERE ID = ?";
    
    // Create a prepared statement
    if ($stmt = $con->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $artwork_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the artist dashboard or a confirmation page after successful deletion
            header("Location: artist_dashboard.php?message=Artwork deleted successfully");
            exit();
        } else {
            // Handle error if deletion fails
            echo "Error deleting artwork: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Handle error if preparation fails
        echo "Error preparing the statement: " . $con->error;
    }
} else {
    // Handle error if 'id' is not set
    echo "Invalid artwork ID.";
}

// Close the database connection
$con->close();
?>
