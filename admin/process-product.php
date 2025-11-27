<?php
// Start a PHP session to store feedback messages.
session_start();

// --- 1. Database Connection Configuration ---
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vmdk_db";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- 2. Check if the Form Was Submitted ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 3. Sanitize and Get Form Data ---
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $product_price = floatval($_POST['product_price']);
    $product_stock = intval($_POST['product_stock']);
    $product_category = $conn->real_escape_string($_POST['product_category']);
    
    // --- 4. Handle Image Upload ---
    $image_path = "";
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $image_name = uniqid() . '-' . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            $image_path = "uploads/" . $image_name;
        } else {
            // Set an error message in the session and redirect
            $_SESSION['form_message'] = "Error: There was a problem uploading the image.";
            $_SESSION['form_message_type'] = "danger"; // For styling
            header("Location: ../admin/add-product.php");
            exit();
        }
    }

    // --- 5. Prepare and Execute SQL INSERT Statement ---
    $sql = "INSERT INTO products (name, description, price, stock, category, image_path) 
            VALUES ('$product_name', '$product_description', '$product_price', '$product_stock', '$product_category', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        // --- SET SUCCESS MESSAGE ---
        $_SESSION['form_message'] = "Success! The product '" . htmlspecialchars($product_name) . "' has been added.";
        $_SESSION['form_message_type'] = "success";
    } else {
        // --- SET ERROR MESSAGE ---
        $_SESSION['form_message'] = "Error: " . $conn->error;
        $_SESSION['form_message_type'] = "danger";
    }

    $conn->close();

} else {
    // If accessed directly, do nothing and just go back.
}

// --- 6. Redirect Back to the Form Page ---
header("Location: ../admin/add-product.php");
exit(); // Always call exit() after a header redirect.
?>