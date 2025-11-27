<?php
// Start the session to access login data and set feedback messages.
session_start();

// --- Security Check ---
// Since we are not using auth-check.php, we must place the security check here.
// This ensures only logged-in admins can access this functionality.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // If not an admin, redirect to the login page.
    header("Location: ../login.php");
    exit;
}

// Check if a product ID was provided in the URL.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // If no ID is provided, redirect back with an error message.
    $_SESSION['message'] = "Error: Invalid product ID provided.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../admin.php?page=manage_products");
    exit;
}

$product_id = (int)$_GET['id'];

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- 1. Get the image path BEFORE deleting the product from the database ---
// This is crucial so we can delete the actual image file from the server.
$sql_select = "SELECT image_path FROM products WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $product_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$product = $result->fetch_assoc();

// Store the image path in a variable. It might be null if no image was set.
$image_to_delete = $product ? $product['image_path'] : null;
$stmt_select->close();


// --- 2. Delete the product row from the database ---
// We use a prepared statement to prevent SQL injection.
$sql_delete = "DELETE FROM products WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $product_id);

if ($stmt_delete->execute()) {
    // --- 3. If database deletion was successful, also delete the image file ---
    // Check if there was an image path and if the file actually exists.
    if ($image_to_delete && file_exists("../" . $image_to_delete)) {
        // The unlink() function deletes a file. The '../' is needed to go up from the 'admin' folder.
        unlink("../" . $image_to_delete); 
    }
    
    // Set a success message to be displayed on the admin page.
    $_SESSION['message'] = "Product was successfully deleted.";
    $_SESSION['message_type'] = "success";
} else {
    // Set an error message if the deletion failed.
    $_SESSION['message'] = "Error: Could not delete the product. " . $conn->error;
    $_SESSION['message_type'] = "danger";
}

$stmt_delete->close();
$conn->close();

// --- 4. Redirect the admin back to the manage products page ---
// The feedback message we set above will be displayed there.
header("Location: ../admin.php?page=manage_products");
exit;
?>
