<?php
session_start();

// Gatekeeper: If the user is not logged in, redirect them to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$user_id = $_SESSION['user_id'];

// --- Fetch User's Order Statistics ---
$stats_stmt = $conn->prepare("SELECT COUNT(id) as total_orders, SUM(total_amount) as total_spent FROM orders WHERE user_id = ?");
$stats_stmt->bind_param("i", $user_id);
$stats_stmt->execute();
$stats_result = $stats_stmt->get_result();
$user_stats = $stats_result->fetch_assoc();

// --- Fetch User's Order History ---
$orders_stmt = $conn->prepare("SELECT id, total_amount, order_date, payment_status FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$orders_stmt->bind_param("i", $user_id);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | VmdK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/SmoothScroll.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Koulen&family=Luckiest+Guy&family=Playball&family=Rubik:ital,wght@0,300..900;1,300..900&family=Signika:wght@300..700&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="page-header navp">
        <div class="container">
            <h1>My Profile</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</p>
        </div>
    </div>

    <main class="profile-section">
        <div class="container">
            <!-- Statistic Cards -->
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <h4>Total Orders</h4>
                        <p><?php echo $user_stats['total_orders'] ? $user_stats['total_orders'] : 0; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <h4>Total Spent</h4>
                        <p>$<?php echo $user_stats['total_spent'] ? number_format($user_stats['total_spent'], 2) : '0.00'; ?></p>
                    </div>
                </div>
            </div>

            <!-- Order History Table -->
            <div class="order-history-card">
                <h3 class="card-title">Order History</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($orders_result->num_rows > 0): ?>
                                <?php while($order = $orders_result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo date("F d, Y", strtotime($order['order_date'])); ?></td>
                                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                        <td><span class="badge text-dark"><?php echo htmlspecialchars($order['payment_status']); ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">You haven't placed any orders yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Your standard footer here -->
</body>
</html>
