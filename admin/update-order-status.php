<?php
session_start();

// Security Check: Ensure an admin is logged in.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Check if the form was submitted correctly.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {

    // --- Database Connection ---
    $conn = new mysqli("localhost", "root", "", "vmdk_db");
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    // Sanitize the input data.
    $order_id = (int)$_POST['order_id'];
    $new_status = $conn->real_escape_string($_POST['status']);

    // --- Prepare and Execute the SQL UPDATE Query ---
    $sql = "UPDATE orders SET payment_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Order status updated successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating order status: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conn->close();

} else {
    // If the request was invalid.
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "danger";
}

// Redirect back to the order details page.
header("Location: ../admin.php?page=order_details&id=" . $order_id);
exit;
?>

