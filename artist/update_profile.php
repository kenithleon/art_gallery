<?php
session_start();
include('includes/dbconnection.php'); // Include your database connection file

if (!isset($_SESSION['artist_id'])) {
    header("Location: artlogin.php"); // Redirect if not logged in
    exit();
}

$artist_id = $_SESSION['artist_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $awards = $_POST['awards'];

    // Update the artist profile
    $sql = "UPDATE tblartist SET Name = ?, MobileNumber = ?, Email = ?, Education = ?, Award = ? WHERE ID = ?";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssi", $name, $mobile, $email, $education, $awards, $artist_id);

    if ($stmt->execute()) {
        // Redirect to artist dashboard after successful update
        header("Location: artist_dashboard.php");
        exit();
    } else {
        $msg = "Error updating profile: " . $stmt->error;
    }
}

// Fetch artist details for pre-filling the form
$sql = "SELECT * FROM tblartist WHERE ID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$result = $stmt->get_result();
$artist = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            background: linear-gradient(to right, #f0f4f8, #cfd9e3);
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin: 1rem 0 0.5rem;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            background: #007bff;
            color: white;
            padding: 0.7rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #0056b3;
        }
        p {
            text-align: center;
            color: green;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <?php if (isset($msg)) { echo "<p>$msg</p>"; } ?>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($artist['Name']); ?>" required>

            <label for="mobile">Mobile Number:</label>
            <input type="text" name="mobile" id="mobile" value="<?php echo htmlspecialchars($artist['MobileNumber']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($artist['Email']); ?>" required>

            <label for="education">Education:</label>
            <textarea name="education" id="education" required><?php echo htmlspecialchars($artist['Education']); ?></textarea>

            <label for="awards">Awards:</label>
            <textarea name="awards" id="awards" required><?php echo htmlspecialchars($artist['Award']); ?></textarea>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$con->close();
?>
