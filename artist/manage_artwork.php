<?php
session_start();
include('includes/dbconnection.php'); // Include your database connection file

if (!isset($_SESSION['artist_id'])) {
    header("Location: artlogin.php"); // Redirect to login if not logged in
    exit();
}

// Fetch all artworks for the logged-in artist
$artist_id = $_SESSION['artist_id'];
$query = "SELECT * FROM tblartproduct WHERE Artist = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $artwork_id = $_POST['artwork_id'];
        $delete_query = "DELETE FROM tblartproduct WHERE ID = ?";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bind_param("i", $artwork_id);
        $delete_stmt->execute();
        header("Location: manage_artwork.php"); // Refresh the page after deletion
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Artwork</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Arial', sans-serif;
            animation: backgroundAnimation 15s ease infinite;
            margin: 0;
            padding: 20px;
        }

        @keyframes backgroundAnimation {
            0% { background-color: #f5f7fa; }
            50% { background-color: #c3cfe2; }
            100% { background-color: #f5f7fa; }
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
            transition: transform 0.5s;
        }

        h1 {
            text-align: center;
            color: #333;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            animation: scaleIn 1s ease-in-out;
        }

        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: rgba(200, 230, 201, 0.5);
            transition: background-color 0.3s ease;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: linear-gradient(45deg, #ff6b6b, #f06595);
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 5px rgba(255, 107, 107, 1);
            }
            to {
                box-shadow: 0 0 20px rgba(255, 107, 107, 0.8);
            }
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        form {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Artwork</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Dimension</th>
                    <th>Orientation</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['ID']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Dimension']; ?></td>
                        <td><?php echo $row['Orientation']; ?></td>
                        <td><?php echo $row['SellingPricing']; ?></td>
                        <td>
                            <a href="edit_artwork.php?id=<?php echo $row['ID']; ?>" class="btn">Edit</a>
                            <form action="manage_artwork.php" method="post">
                                <input type="hidden" name="artwork_id" value="<?php echo $row['ID']; ?>">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this artwork?');" class="btn" style="background-color: #ff4d4d;">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="add_artwork.php" class="btn">Add New Artwork</a>
    </div>
</body>
</html>
