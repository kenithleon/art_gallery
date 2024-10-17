<?php
// Include database connection
include('includes/dbconnection.php');

if (isset($_GET['id'])) {
    $artwork_id = $_GET['id'];

    // Fetch artwork details
    $query = "SELECT * FROM tblartproduct WHERE ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $artwork_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $artwork = $result->fetch_assoc();
    } else {
        echo "Artwork not found!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update artwork details
    $title = $_POST['title'];
    $dimension = $_POST['dimension'];
    $orientation = $_POST['orientation'];
    $size = $_POST['size'];
    $selling_price = $_POST['selling_price'];
    $description = $_POST['description'];

    $update_query = "UPDATE tblartproduct SET Title = ?, Dimension = ?, Orientation = ?, Size = ?, SellingPricing = ?, Description = ? WHERE ID = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("ssssssi", $title, $dimension, $orientation, $size, $selling_price, $description, $artwork_id);

    if ($update_stmt->execute()) {
        echo "Artwork updated successfully!";
        header("Location: artist_dashboard.php");
        exit();
    } else {
        echo "Error updating artwork.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artwork</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input:focus, textarea:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-align: center;
            display: block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Artwork</h1>
        <form action="" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo isset($artwork['Title']) ? $artwork['Title'] : ''; ?>" required>

            <label for="dimension">Dimension:</label>
            <input type="text" id="dimension" name="dimension" value="<?php echo isset($artwork['Dimension']) ? $artwork['Dimension'] : ''; ?>" required>

            <label for="orientation">Orientation:</label>
            <input type="text" id="orientation" name="orientation" value="<?php echo isset($artwork['Orientation']) ? $artwork['Orientation'] : ''; ?>" required>

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" value="<?php echo isset($artwork['Size']) ? $artwork['Size'] : ''; ?>" required>

            <label for="selling_price">Selling Price:</label>
            <input type="number" id="selling_price" name="selling_price" value="<?php echo isset($artwork['SellingPricing']) ? $artwork['SellingPricing'] : ''; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo isset($artwork['Description']) ? $artwork['Description'] : ''; ?></textarea>

            <button type="submit">Update Artwork</button>
        </form>
        <a href="artist_dashboard.php">Cancel</a>
    </div>
</body>
</html>
