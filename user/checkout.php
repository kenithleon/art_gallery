<?php
session_start();
include('includes/dbconnection.php'); // Include your database connection

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if user is not logged in
    header("Location: login.php");
    exit;
}

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Initialize confirmation message
$confirmation_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    // Get product ID from the form
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    // Ensure all form inputs exist before using them
    $user_name = isset($_POST['user_name']) ? mysqli_real_escape_string($con, $_POST['user_name']) : '';
    $delivery_address = isset($_POST['delivery_address']) ? mysqli_real_escape_string($con, $_POST['delivery_address']) : '';
    $phone_number = isset($_POST['phone_number']) ? mysqli_real_escape_string($con, $_POST['phone_number']) : '';
    $payment_option = isset($_POST['payment_option']) ? mysqli_real_escape_string($con, $_POST['payment_option']) : '';

    // Only proceed if all fields are filled
    if (!empty($user_name) && !empty($delivery_address) && !empty($phone_number) && !empty($payment_option)) {
        // Calculate delivery date (1 week later)
        $delivery_date = date('Y-m-d', strtotime('+1 week'));

        // Insert order into tblorder
        $insert_order_query = "INSERT INTO tblorder (user_id, product_id, user_name, delivery_address, phone_number, payment_option, delivery_date) VALUES ('$user_id', '$product_id', '$user_name', '$delivery_address', '$phone_number', '$payment_option', '$delivery_date')";
        mysqli_query($con, $insert_order_query);

        // Prepare confirmation message
        $confirmation_message = "
            <h3>Thank you, $user_name!</h3>
            <p>Your item has been successfully checked out.</p>
            <p>Your estimated delivery date is: <strong>$delivery_date</strong></p>
            <p>We will contact you at: <strong>$phone_number</strong></p>
        ";

        // Clear the cart after successful order
        $delete_cart_query = "DELETE FROM tblcart WHERE user_id = '$user_id'";
        mysqli_query($con, $delete_cart_query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file --> <!-- Include your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #28a745; /* Bootstrap success color */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #218838; /* Darker shade on hover */
        }

        textarea {
            resize: none; /* Prevent resizing */
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #e8f5e9; /* Light green background */
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #388e3c; /* Darker green border */
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 8px;
            animation: pop 0.5s ease forwards; /* Add pop animation */
            color: #388e3c; /* Dark green text color */
        }

        /* Animation styles for modal */
        @keyframes pop {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .continue-shopping {
            background-color: #388e3c; /* Dark green background */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 20px;
        }

        .continue-shopping:hover {
            background-color: #2e7d32; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>

        <?php if (empty($confirmation_message)) { ?>
            <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo isset($_POST['product_id']) ? htmlspecialchars($_POST['product_id']) : ''; ?>">
                <label for="user_name">Name:</label>
                <input type="text" name="user_name" required>

                <label for="delivery_address">Delivery Address:</label>
                <textarea name="delivery_address" rows="4" required></textarea>

                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" required>

                <label for="payment_option">Payment Option:</label>
                <select name="payment_option" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>

                <input type="submit" value="Place Order">
            </form>
        <?php } else { ?>
            <div class="confirmation-message">
                <?php echo $confirmation_message; ?>
                <a href="product.php"><button class="continue-shopping">Continue Shopping</button></a>
            </div>
        <?php } ?>

        <div class="footer">
            <p>Secure payment processing. Your information is safe with us.</p>
        </div>
    </div>
</body>
</html>