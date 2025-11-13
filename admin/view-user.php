<?php
// Start session
session_start();

// Include database configuration file
include('includes/dbconnection.php');

// Fetch users data from tbuser table
$query = "SELECT * FROM tbuser";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="css/style2.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h2>User Details</h2>
        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through all the users and display them
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        echo "<td>" . $row['user_phone'] . "</td>";
                        // echo "<td><a href='edit-user.php?user_id=" . $row['user_id'] . "'>Edit</a> | <a href='delete-user.php?user_id=" . $row['user_id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="back-btn">
            <a href="dashboard.php" class="button">Back to Dashboard</a>
        </div>
    </div>

    <style>
        .back-btn {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
