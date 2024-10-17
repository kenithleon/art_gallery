<?php
// Start the session
session_start();

// Include database configuration file
include('includes/dbconnection.php');

// Check if form is submitted
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $dimension = $_POST['dimension'];
    $orientation = $_POST['orientation'];
    $size = $_POST['size'];
    $artist = $_SESSION['artist_id'];  // Assuming the artist ID is stored in session
    $art_type = $_POST['art_type'];
    $art_medium = $_POST['art_medium'];
    $selling_price = $_POST['selling_price'];
    $description = $_POST['description'];

    // Image upload
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);

    // Check if uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // SQL Query to insert artwork details
        $query = "INSERT INTO tblartproduct (Title, Dimension, Orientation, Size, Artist, ArtType, ArtMedium, SellingPricing, Description, Image) 
                  VALUES ('$title', '$dimension', '$orientation', '$size', '$artist', '$art_type', '$art_medium', '$selling_price', '$description', '$image')";

        // Now execute the query
        if (mysqli_query($con, $query)) {
            // Redirect to the success page
            header("Location: success.php");
            exit(); // Terminate the script after the redirect
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    } else {
        echo "Error uploading the image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artwork</title>
    <link rel="stylesheet" href="css/style4.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3; /* Light grey background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #ff7e5f;
        }

        input[type="submit"],
        .back-button {
            background: #ff7e5f;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
            margin-top: 15px;
        }

        input[type="submit"]:hover,
        .back-button:hover {
            background: #feb47b;
        }

        .back-button {
            background: transparent;
            color: #ff7e5f;
            border: 2px solid #ff7e5f;
        }

        .back-button:hover {
            background: #ff7e5f;
            color: white;
        }

        /* Magic animation */
        @keyframes float {
            0% { transform: translatey(0); }
            50% { transform: translatey(-10px); }
            100% { transform: translatey(0); }
        }

        .container {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Artwork</h2>
        <form action="add_artwork.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" required>

            <label for="dimension">Dimension:</label>
            <input type="text" name="dimension" required>

            <label for="orientation">Orientation:</label>
            <input type="text" name="orientation" required>

            <label for="size">Size:</label>
            <input type="text" name="size" required>

            <label for="art_type">Art Type:</label>
            <select name="art_type" required>
            <?php
            // Fetch art types from tblarttype
            $result = mysqli_query($con, "SELECT * FROM tblarttype");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ID'] . "'>" . $row['ArtType'] . "</option>";
            }
            ?>
            </select>

            <label for="art_medium">Art Medium:</label>
            <select name="art_medium">
            <?php
            // Fetch art mediums from tblartmedium
            $result = mysqli_query($con, "SELECT * FROM tblartmedium");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ID'] . "'>" . $row['ArtMedium'] . "</option>";
            }
            ?>
            </select>

            <label for="selling_price">Selling Price:</label>
            <input type="number" name="selling_price" required>

            <label for="description">Description:</label>
            <textarea name="description"></textarea>

            <label for="image">Image:</label>
            <input type="file" name="image" required>

            <input type="submit" name="submit" value="Add Artwork">
            <button type="button" class="back-button" onclick="window.location.href='artist_dashboard.php';">Back to Dashboard</button>
        </form>
    </div>
</body>
</html>
