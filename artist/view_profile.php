<?php
session_start();
if (!isset($_SESSION['artist_id'])) {
    header("Location: artlogin.php");
    exit();
}

// Database connection
include('includes/dbconnection.php');

$artist_id = $_SESSION['artist_id'];

// Fetch artist information
$sql = "SELECT * FROM tblartist WHERE ID = ?";
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
    <title>View Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f0f8ff; /* Light background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            overflow: hidden;
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: float 2s ease-in-out infinite; /* Magic animation */
            position: relative;
            overflow: hidden;
        }

        /* Floating effect */
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6a5acd; /* Magic color */
            text-shadow: 2px 2px 8px rgba(106, 90, 205, 0.8); /* Glowing effect */
        }

        p {
            font-size: 18px;
            margin: 15px 0;
            line-height: 1.5;
            transition: transform 0.3s ease;
        }

        p:hover {
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        strong {
            color: #6a5acd;
            text-shadow: 1px 1px 4px rgba(106, 90, 205, 0.5);
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #6a5acd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        a::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transition: width 0.4s ease, height 0.4s ease, top 0.4s ease, left 0.4s ease;
            z-index: 0;
            transform: translate(-50%, -50%) scale(0);
        }

        a:hover::before {
            width: 400%;
            height: 400%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
        }

        a:hover {
            color: #6a5acd;
        }

        @media (max-width: 600px) {
            .profile-container {
                padding: 20px;
            }
            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h2>Profile of <?php echo htmlspecialchars($artist['Name']); ?></h2> <!-- Use htmlspecialchars for safety -->

    <p><strong>Email:</strong> <?php echo htmlspecialchars($artist['Email']); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($artist['MobileNumber']); ?></p>
    <p><strong>Education:</strong> <?php echo htmlspecialchars($artist['Education']); ?></p>
    <p><strong>Awards:</strong> <?php echo isset($artist['Awards']) ? htmlspecialchars($artist['Awards']) : 'No awards listed'; ?></p>
    
    <a href="update_profile.php">Edit Profile</a>
    <a href="artist_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>

<?php
$con->close();
?>
