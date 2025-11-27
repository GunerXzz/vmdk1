<?php
session_start();

// --- Security Check ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Check if the form was submitted and a product ID is present.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {

    $product_id = (int)$_POST['product_id'];

    // --- Database Connection ---
    $conn = new mysqli("localhost", "root", "", "vmdk_db");
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    // --- Sanitize Form Data ---
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $product_description = $conn->real_escape_string($_POST['product_description']);
    $product_price = floatval($_POST['product_price']);
    $product_stock = intval($_POST['product_stock']);

    // --- Handle Image Upload (if a new one was provided) ---
    $new_image_path = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        // First, get the old image path to delete it later.
        $result = $conn->query("SELECT image_path FROM products WHERE id = $product_id");
        $old_image_path = $result->fetch_assoc()['image_path'];

        // Process and save the new image.
        $target_dir = "../uploads/";
        $image_name = uniqid() . '-' . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $image_name;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            $new_image_path = "uploads/" . $image_name;
            // If upload was successful, delete the old image file.
            if ($old_image_path && file_exists("../" . $old_image_path)) {
                unlink("../" . $old_image_path);
            }
        }
    }

    // --- Construct the SQL UPDATE Query ---
    $sql = "UPDATE products SET 
                name = ?, 
                description = ?, 
                price = ?, 
                stock = ? ";
    
    // Only add the image_path to the query if a new image was uploaded.
    if ($new_image_path) {
        $sql .= ", image_path = ? ";
    }
    
    $sql .= "WHERE id = ?";

    $stmt = $conn->prepare($sql);

    // Bind parameters based on whether a new image was uploaded.
    if ($new_image_path) {
        $stmt->bind_param("ssdisi", $product_name, $product_description, $product_price, $product_stock, $new_image_path, $product_id);
    } else {
        $stmt->bind_param("ssdis", $product_name, $product_description, $product_price, $product_stock, $product_id);
    }

    // --- Execute Query and Redirect ---
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product updated successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating product: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger";
}

header("Location: ../admin.php?page=manage_products");
exit;
?>
