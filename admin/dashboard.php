<?php
session_start();

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- Fetch Dashboard Data ---
$total_products_result = $conn->query("SELECT COUNT(id) as total FROM products");
$total_products = $total_products_result->fetch_assoc()['total'];

$total_stock_result = $conn->query("SELECT SUM(stock) as total_stock FROM products");
$total_stock = $total_stock_result->fetch_assoc()['total_stock'];

$total_orders_result = $conn->query("SELECT COUNT(id) as total_orders FROM orders");
$total_orders = $total_orders_result->fetch_assoc()['total_orders'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | VmdK Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css"> <!-- Link to the new CSS file -->
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; // Include the reusable sidebar ?>

        <main class="main-content">
            <div class="container-fluid">
                <div class="header-bar">
                    <h1 class="page-title">Dashboard</h1>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                </div>
                
                <!-- Summary Cards can be added here later -->
                
                <div class="content-card">
                    <div class="card-header"><h3>Overview</h3></div>
                    <div class="card-body">
                        <p>Welcome to your VmdK Admin Dashboard. From here you can manage your products, view orders, and more.</p>
                        <ul>
                            <li><strong>Total Products:</strong> <?php echo $total_products; ?></li>
                            <li><strong>Total Items in Stock:</strong> <?php echo $total_stock ? $total_stock : 0; ?></li>
                            <li><strong>Total Orders:</strong> <?php echo $total_orders; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
