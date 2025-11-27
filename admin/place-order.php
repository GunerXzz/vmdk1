<?php
session_start();

// --- Security Check: User must be logged in to place an order ---
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = '/ament/checkout.php';
    header('Location: ../login.php');
    exit;
}

// Redirect if cart is empty or if this page is accessed directly
if (empty($_SESSION['cart']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: ../shop.php');
    exit;
}

// --- 1. Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- 2. Sanitize Customer Data from Form ---
$user_id = $_SESSION['user_id'];
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$customer_name = $firstname . ' ' . $lastname;
$customer_address = $conn->real_escape_string($_POST['address']);
$customer_city = $conn->real_escape_string($_POST['city']);
$customer_phone = $conn->real_escape_string($_POST['phone']);
$customer_email = $conn->real_escape_string($_POST['email']);

// --- NEW: Capture the selected payment method ---
$payment_method = $conn->real_escape_string($_POST['payment_method']);


// --- 3. Use a Database Transaction for Safety ---
$conn->begin_transaction();

try {
    // --- 4. Fetch Product Details and Calculate Final Total ---
    $cart_items_details = [];
    $total_price = 0;
    $product_ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $product_ids);

    if (empty($ids_string)) { throw new Exception("Your cart is empty."); }

    $sql = "SELECT id, name, price, stock FROM products WHERE id IN ($ids_string)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $quantity = $_SESSION['cart'][$product_id]['quantity'];
            if ($row['stock'] < $quantity) {
                throw new Exception("Sorry, product '" . htmlspecialchars($row['name']) . "' is out of stock.");
            }
            $row['quantity'] = $quantity;
            $total_price += $row['price'] * $quantity;
            $cart_items_details[$product_id] = $row;
        }
    } else {
        throw new Exception("An error occurred while fetching your cart items.");
    }
    
    // --- UPDATED: Insert the Main Order into the `orders` Table ---
    // The query now includes the 'payment_method' column and its value.
    $sql_order = "INSERT INTO orders (user_id, customer_name, customer_address, customer_city, customer_phone, customer_email, total_amount, payment_method)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("isssssds", $user_id, $customer_name, $customer_address, $customer_city, $customer_phone, $customer_email, $total_price, $payment_method);
    
    if (!$stmt_order->execute()) {
        throw new Exception("There was an error creating your order record: " . $conn->error);
    }
    
    $order_id = $conn->insert_id;

    // --- Insert Each Product into `order_items` and Update Stock ---
    foreach ($cart_items_details as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price_per_item = $item['price'];

        $sql_items = "INSERT INTO order_items (order_id, product_id, quantity, price_per_item) VALUES (?, ?, ?, ?)";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("iiid", $order_id, $product_id, $quantity, $price_per_item);
        if (!$stmt_items->execute()) { throw new Exception("Error adding order items: " . $conn->error); }

        $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE id = ?";
        $stmt_stock = $conn->prepare($sql_update_stock);
        $stmt_stock->bind_param("ii", $quantity, $product_id);
        if (!$stmt_stock->execute()) { throw new Exception("Error updating stock: " . $conn->error); }
    }

    $conn->commit();

    // --- Clear the Cart and Redirect ---
    unset($_SESSION['cart']);
    $_SESSION['last_order_id'] = $order_id;
    
    header("Location: ../thank-you.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['checkout_error'] = $e->getMessage();
    header("Location: ../checkout.php");
    exit();
}

$conn->close();
?>
