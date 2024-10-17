<?php
session_start(); // Start the session if not already started
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f8ff; /* Light background for contrast */
            font-family: Arial, sans-serif;
        }

        .message {
            text-align: center;
            padding: 20px;
            border: 2px solid #4caf50; /* Green border */
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out, pulse 1.5s infinite; /* Apply animations */
        }

        /* Keyframe animation for fade-in effect */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Keyframe animation for pulsing effect */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4caf50; /* Green background for the link */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Artwork added successfully!</h2>
        <a href="add_artwork.php">Add another artwork</a>
    </div>
</body>
</html>
