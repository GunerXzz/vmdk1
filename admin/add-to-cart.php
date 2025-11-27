<?php
// Start the session to store cart data. This must be at the very top.
session_start();

// Check if a product ID was sent to this script
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    
    $product_id = (int)$_POST['product_id'];

    // Initialize the cart if it doesn't exist yet
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If it is, just increase the quantity
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // If it's not, add it to the cart with a quantity of 1
        // In a real application, you'd fetch the product name and price from the database here
        // For now, we'll handle that on the cart page itself.
        $_SESSION['cart'][$product_id] = [
            'quantity' => 1
        ];
    }
}

// Redirect the user back to the shop page after adding the item
header('Location: ../shop.php');
exit();

?>