<?php
session_start();

// --- DATABASE CONNECTION ---
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vmdk_db";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    // In a real app, you'd log this error. For AJAX, we send back an error response.
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// --- INITIALIZE CART IF IT DOESN'T EXIST ---
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// --- HANDLE ACTIONS ---
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'update':
        $product_id = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if ($product_id > 0) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                // If quantity is 0 or less, remove the item
                unset($_SESSION['cart'][$product_id]);
            }
        }
        break;

    case 'remove':
        $product_id = (int)($_POST['product_id'] ?? 0);
        if ($product_id > 0) {
            unset($_SESSION['cart'][$product_id]);
        }
        break;
}

// --- CALCULATE NEW TOTALS AND SEND RESPONSE ---
$total_price = 0;
$total_items = 0;
$updated_subtotals = [];

if (!empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $product_ids);

    if (!empty($ids_string)) {
        $sql = "SELECT id, price FROM products WHERE id IN ($ids_string)";
        $result = $conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[$row['id']] = $row;
        }

        foreach ($_SESSION['cart'] as $id => $item) {
            if (isset($products[$id])) {
                $subtotal = $products[$id]['price'] * $item['quantity'];
                $total_price += $subtotal;
                $updated_subtotals[$id] = number_format($subtotal, 2);
                $total_items += $item['quantity'];
            }
        }
    }
}

$conn->close();

// --- SEND JSON RESPONSE ---
// This is what the JavaScript will receive.
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'total_price' => number_format($total_price, 2),
    'total_items' => $total_items,
    'subtotals' => $updated_subtotals
]);
exit();
?>