<?php
session_start();
include('includes/dbconnection.php');

// Ensure that the user is logged in and product_id is set
if (isset($_POST['product_id']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id']; // Get logged-in user ID

    // Check if the product is already in the cart
    $check_stmt = $con->prepare("SELECT quantity FROM tblcart WHERE user_id = ? AND product_id = ?");
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If the product is already in the cart, update the quantity
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1; // Increase quantity by 1

        $update_stmt = $con->prepare("UPDATE tblcart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update_stmt->execute();
    } else {
        // If the product is not in the cart, insert a new record
        $insert_stmt = $con->prepare("INSERT INTO tblcart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $quantity = 1; // Default quantity to 1
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insert_stmt->execute();
    }

    // Redirect to cart page or wherever you want
    header("Location: cart.php");
    exit();
} else {
    // Handle the case where the user is not logged in or product_id is not set
    echo "You must be logged in to add products to your cart.";
}
?>
