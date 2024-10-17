<?php
session_start();
if (!isset($_SESSION['artist_id'])) { // Make sure the session is set correctly
    header("Location: artlogin.php");
    exit();
}

// Database connection
include('includes/dbconnection.php');

$artist_id = $_SESSION['artist_id'];

// Fetch artist information
$sql = "SELECT * FROM tblartist WHERE ID = ?"; // Updated to match your table
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$artist = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0; /* Light grey background */
            color: #333; /* Darker text color for contrast */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1200px;
            overflow: hidden;
            display: flex;
        }

        .sidebar {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 15px 0 0 15px;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        h2 {
            text-align: center;
            padding: 20px;
            background: linear-gradient(90deg, #ff6a00, #ee0979);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2em;
            margin: 0;
        }

        .sidebar ul {
            list-style: none;
            margin-top: 20px;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333; /* Dark text for links */
            font-size: 18px;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
            position: relative;
            display: inline-block;
        }

        .sidebar ul li a::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            height: 2px;
            width: 0;
            background: #ffeb3b;
            transition: width 0.4s ease, left 0.4s ease;
        }

        .sidebar ul li a:hover::before {
            width: 100%;
            left: 0;
        }

        .main-content {
            padding: 20px;
            flex-grow: 1;
        }

        h3 {
            text-align: center;
            margin: 20px 0;
            color: #ff6a00; /* Highlighted color for headings */
            font-size: 1.5em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            animation: fadeIn 0.5s;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd; /* Light border color */
            transition: background-color 0.3s, transform 0.2s;
        }

        th {
            background-color: rgba(255, 255, 255, 0.5);
            color: #333;
            animation: fadeIn 0.7s;
        }

        td {
            background-color: rgba(255, 255, 255, 0.2);
            color: #333;
        }

        td:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                border-radius: 15px;
                min-width: 100%;
            }

            h2 {
                font-size: 1.5em;
            }

            .sidebar ul li a {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($artist['Name']); ?>!</h2> <!-- Use the correct column name -->
            <!-- Navigation for Dashboard -->
            <ul>
                <li><a href="add_artwork.php">Add Artwork</a></li>
                <li><a href="manage_artwork.php">Manage Artwork</a></li>
                <li><a href="view_profile.php">View Profile</a></li>
                <!-- <li><a href="update_profile.php">Update Profile</a></li> -->
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <h3>Your Artwork</h3>

            <!-- Display Artworks from the Database -->
            <table>
                <thead>
                    <tr>
                        <th>Artwork ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblartproduct WHERE Artist = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $artist_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($artwork = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($artwork['ID']) . "</td>";
                        echo "<td>" . htmlspecialchars($artwork['Title']) . "</td>";
                        echo "<td>" . htmlspecialchars($artwork['Description']) . "</td>";
                        echo "<td>" . htmlspecialchars($artwork['SellingPricing']) . "</td>";
                        echo "<td>";
                        echo "<a href='edit_artwork.php?id=" . htmlspecialchars($artwork['ID']) . "'>Edit</a> | ";
                        echo "<a href='delete_artwork.php?id=" . htmlspecialchars($artwork['ID']) . "'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$con->close();
?>
