<?php
session_start();

// Include database connection or any other necessary files
include('includes/dbconnection.php');

// Assuming that order details are passed through session or URL
$order_id = $_SESSION['order_id'] ?? '';
$amount = $_SESSION['amount'] ?? '';
$payment_status = $_SESSION['payment_status'] ?? '';

// Clear session variables after displaying success page
unset($_SESSION['order_id']);
unset($_SESSION['amount']);
unset($_SESSION['payment_status']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success - Order Confirmed</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
    <!-- Include header if necessary -->
    <?php include_once('includes/header.php'); ?>

    <div class="container">
        <div class="success-message text-center mt-5">
            <h2>Thank You! Your Order is Confirmed.</h2>
            <p>Your order has been successfully placed and is being processed.</p>

            <!-- Display Order Details -->
            <?php if ($order_id && $amount): ?>
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
                <p><strong>Amount Paid:</strong> $<?php echo htmlspecialchars($amount); ?></p>
                <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($payment_status); ?></p>
            <?php else: ?>
                <p>Sorry, we couldn't retrieve your order details. Please check your order history or contact support.</p>
            <?php endif; ?>

            <!-- Button to go back to homepage -->
            <div class="mt-4">
                <a href="index.php" class="btn btn-primary">Go to Homepage</a>
                <a href="products.php" class="btn btn-success">Continue Shopping</a>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- JavaScript files -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
