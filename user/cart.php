<?php
session_start();
include('includes/dbconnection.php');

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in the session

    // Check if the cart already has the product
    $query = "SELECT * FROM tblcart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if product already in cart
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

        $update_query = "UPDATE tblcart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $con->prepare($update_query);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update_stmt->execute();
    } else {
        // Insert new product into cart
        $insert_query = "INSERT INTO tblcart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $con->prepare($insert_query);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $insert_stmt->execute();
    }

    header('Location: cart.php');
    exit;
}

// Remove from cart functionality
if (isset($_GET['remove'])) {
    $cart_id = $_GET['remove'];

    $delete_query = "DELETE FROM tblcart WHERE cart_id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bind_param("i", $cart_id);
    $delete_stmt->execute();
    
    header('Location: cart.php');
    exit;
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $update_query = "UPDATE tblcart SET quantity = ? WHERE cart_id = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param("ii", $quantity, $cart_id);
    $update_stmt->execute();

    header('Location: cart.php');
    exit;
}

// Fetch cart items for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming the user is logged in
$cart_query = "SELECT c.cart_id, c.quantity, p.Title, p.SellingPricing 
               FROM tblcart c
               JOIN tblartproduct p ON c.product_id = p.ID
               WHERE c.user_id = ?";
$cart_stmt = $con->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style30.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($cart_result->num_rows > 0) {
                    $total_price = 0;
                    while ($row = $cart_result->fetch_assoc()) {
                        $total_price += $row['SellingPricing'] * $row['quantity'];
                ?>
                    <tr>
                        <td><?php echo $row['Title']; ?></td>
                        <td>
                            <form method="post" action="cart.php">
                                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                                <button type="submit" name="update_cart">Update</button>
                            </form>
                        </td>
                        <td><?php echo $row['SellingPricing']; ?></td>
                        <td>
                            <a href="cart.php?remove=<?php echo $row['cart_id']; ?>">Remove</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php if ($cart_result->num_rows > 0) { ?>
            <h3>Total Price: <?php echo $total_price; ?></h3>
            <a href="checkout.php" class="proceed-checkout-button">Proceed to Checkout</a> <!-- Link to checkout page -->
        <?php } ?>
        
        <!-- Continue Shopping Button -->
        <a href="product.php" class="continue-shopping-button">Continue Shopping</a>
    </div>

    <style>
        /* Optional: Add some basic styling for the button */
        .continue-shopping-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .continue-shopping-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .proceed-checkout-button {
    display: inline-block; /* Allows for padding and margin */
    padding: 10px 20px; /* Top & Bottom | Left & Right padding */
    background-color: #28a745; /* Bootstrap success color */
    color: white; /* Text color */
    text-align: center; /* Center the text */
    text-decoration: none; /* Remove underline */
    border-radius: 5px; /* Rounded corners */
    margin-top: 20px; /* Space above the button */
    font-weight: bold; /* Bold text */
    transition: background-color 0.3s ease; /* Smooth background color transition */
}

.proceed-checkout-button:hover {
    background-color: #218838; /* Darker shade on hover */
}

    </style>
</body>
</html>
