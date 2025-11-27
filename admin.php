<?php
// Start the session and perform security check
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Determine which page to show. Default to 'dashboard'.
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | VmdK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css"> <!-- Link to your admin CSS file -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a class="navbar-brand logo-font" href="index.php">VmdK<span>.</span></a>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?php echo ($page == 'dashboard') ? 'active' : ''; ?>" href="admin.php?page=dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($page == 'add_product') ? 'active' : ''; ?>" href="admin.php?page=add_product"><i class="fas fa-plus-circle"></i> Add Product</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($page == 'manage_products' || $page == 'edit_product') ? 'active' : ''; ?>" href="admin.php?page=manage_products"><i class="fas fa-box-open"></i> Manage Products</a></li>
                <li class="nav-item"><a class="nav-link <?php echo ($page == 'orders') ? 'active' : ''; ?>" href="admin.php?page=orders"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li class="nav-item mt-auto"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Back to site</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <div class="container-fluid">
                
                <?php if ($page == 'dashboard'): ?>
                    <!-- =================== NEW DASHBOARD CONTENT =================== -->
                    <?php
                        // --- Fetch all necessary data for the dashboard ---
                        $total_stock_result = $conn->query("SELECT SUM(stock) as total_stock FROM products");
                        $total_stock = $total_stock_result->fetch_assoc()['total_stock'];

                        $total_sold_result = $conn->query("SELECT SUM(quantity) as total_sold FROM order_items");
                        $total_sold = $total_sold_result->fetch_assoc()['total_sold'];

                        $total_orders_result = $conn->query("SELECT COUNT(id) as total_orders FROM orders");
                        $total_orders = $total_orders_result->fetch_assoc()['total_orders'];

                        $total_earnings_result = $conn->query("SELECT SUM(total_amount) as total_earnings FROM orders");
                        $total_earnings = $total_earnings_result->fetch_assoc()['total_earnings'];

                        // --- Fetch data for the chart ---
                        $orders_chart_result = $conn->query("
                            SELECT DATE(order_date) as date, COUNT(id) as order_count 
                            FROM orders 
                            WHERE order_date >= CURDATE() - INTERVAL 30 DAY 
                            GROUP BY DATE(order_date) 
                            ORDER BY date ASC
                        ");
                        $chart_labels = [];
                        $chart_order_data = [];
                        while($row = $orders_chart_result->fetch_assoc()) {
                            $chart_labels[] = date("M d", strtotime($row['date']));
                            $chart_order_data[] = $row['order_count'];
                        }
                    ?>
                    <div class="header-bar">
                        <h1 class="page-title">Dashboard</h1>
                        <span>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>!</span>
                    </div>
                    
                    <!-- Redesigned Stat Cards -->
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card">
                                <div class="icon-bg bg-brown"><i class="fas fa-warehouse"></i></div>
                                <div class="stat-info">
                                    <h4>Total In-Stock</h4>
                                    <p><?php echo $total_stock ? number_format($total_stock) : 0; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card">
                                <div class="icon-bg bg-grey"><i class="fas fa-tags"></i></div>
                                <div class="stat-info">
                                    <h4>Total Sold (Items)</h4>
                                    <p><?php echo $total_sold ? number_format($total_sold) : 0; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="stat-card">
                                <div class="icon-bg bg-dark"><i class="fas fa-check-circle"></i></div>
                                <div class="stat-info">
                                    <h4>Orders</h4>
                                    <p><?php echo number_format($total_orders); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Row -->
                    <div class="row">
                        <!-- Chart Column -->
                        <div class="col-lg-8">
                            <div class="content-card">
                                <div class="card-header"><h3>Monthly Orders</h3></div>
                                <div class="card-body"><canvas id="mainChart"></canvas></div>
                            </div>
                        </div>
                        <!-- Total Earnings Column -->
                        <div class="col-lg-4">
                            <div class="content-card">
                                <div class="earnings-card">
                                    <h3>Total Earnings</h3>
                                    <p class="total-amount">$<?php echo $total_earnings ? number_format($total_earnings, 2) : '0.00'; ?></p>
                                    <p>All-time revenue from completed orders.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php elseif ($page == 'add_product'): ?>
                    <!-- =================== ADD PRODUCT CONTENT =================== -->
                    <div class="header-bar">
                        <h1 class="page-title">Add New Product</h1>
                    </div>
                    <div class="content-card">
                        <div class="card-header"><h3>Product Details</h3></div>
                        <div class="card-body">
                            <form action="admin/process-product.php" method="POST" enctype="multipart/form-data">
                                <!-- All your form fields go here -->
                                <div class="mb-3"><label for="productName" class="form-label">Product Name</label><input type="text" class="form-control" id="productName" name="product_name" required></div>
                                <div class="mb-3"><label for="productDescription" class="form-label">Description</label><textarea class="form-control" id="productDescription" name="product_description" rows="4"></textarea></div>
                                <div class="mb-3">
                                    <label for="productCategory" class="form-label">Category</label>
                                    <select class="form-select" id="productCategory" name="product_category" required>
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="chair">Chair</option>
                                        <option value="table">Table</option>
                                        <option value="combo">Combo</option>

                                        <!-- Add more categories as needed -->
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="productPrice" class="form-label">Price ($)</label>
                                        <input type="number" class="form-control" id="productPrice" name="product_price" step="0.01" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productStock" class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" id="productStock" name="product_stock" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Product Image</label>
                                    <input class="form-control" type="file" id="productImage" name="product_image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Product</button>
                            </form>
                        </div>
                    </div>

                <?php elseif ($page == 'manage_products'): ?>
                    <!-- =================== MANAGE PRODUCTS CONTENT =================== -->
                    <?php $products_result = $conn->query("SELECT * FROM products ORDER BY id DESC"); ?>
                    <div class="header-bar">
                        <h1 class="page-title">Manage Products</h1>
                        <a href="admin.php?page=add_product" class="btn btn-primary">Add New Product</a>
                    </div>
                    <div class="content-card">
                        <div class="card-body">
                            <table class="table table-hover table-admin">
                                <thead><tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
                                <tbody>
                                    <?php while($product = $products_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="" class="product-image-thumb"></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo $product['stock']; ?></td>
                                        <td>
                                            <a href="admin/edit-product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="admin/delete-product.php?id=<?php echo $product['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                               Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($page == 'orders'): ?>
                    <!-- =================== NEW: ORDERS CONTENT =================== -->
                    <?php
                        // Fetch all orders from the database, showing the newest ones first.
                        $orders_result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
                    ?>
                    <div class="header-bar">
                        <h1 class="page-title">Manage Orders</h1>
                    </div>
                    <div class="content-card">
                        <div class="card-body">
                            <table class="table table-hover table-admin">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($orders_result->num_rows > 0): ?>
                                        <?php while($order = $orders_result->fetch_assoc()): ?>
                                        <tr>
                                            <td>#<?php echo $order['id']; ?></td>
                                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <!-- Format the date to be more readable -->
                                            <td><?php echo date("M d, Y, h:i A", strtotime($order['order_date'])); ?></td>
                                            <td>
                                                <a href="admin.php?page=order_details&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">View Details</a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No orders found yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
              <?php elseif ($page == 'order_details'): ?>
                    <!-- =================== FINAL: ORDER DETAILS CONTENT =================== -->
                    <?php
                        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { die("Invalid Order ID."); }
                        $order_id = (int)$_GET['id'];
                        
                        // Fetch the main order details
                        $order_stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
                        $order_stmt->bind_param("i", $order_id);
                        $order_stmt->execute();
                        $order_result = $order_stmt->get_result();
                        $order = $order_result->fetch_assoc();
                        if (!$order) { die("Order not found."); }

                        // Fetch the items associated with this order
                        $items_stmt = $conn->prepare("
                            SELECT oi.*, p.name as product_name, p.image_path 
                            FROM order_items oi 
                            JOIN products p ON oi.product_id = p.id 
                            WHERE oi.order_id = ?
                        ");
                        $items_stmt->bind_param("i", $order_id);
                        $items_stmt->execute();
                        $items_result = $items_stmt->get_result();
                    ?>
                    <div class="header-bar">
                        <h1 class="page-title">Order Details: #<?php echo $order['id']; ?></h1>
                        <a href="admin.php?page=orders" class="btn btn-secondary">Back to Orders</a>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="content-card">
                                <div class="card-header"><h3>Items Ordered</h3></div>
                                <div class="card-body">
                                    <table class="table table-admin">
                                        <thead><tr><th>Image</th><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead>
                                        <tbody>
                                            <?php while($item = $items_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="" class="product-image-thumb"></td>
                                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td>$<?php echo number_format($item['price_per_item'], 2); ?></td>
                                                <td>$<?php echo number_format($item['price_per_item'] * $item['quantity'], 2); ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="content-card">
                                <div class="card-header"><h3>Customer & Payment Details</h3></div>
                                <div class="card-body">
                                    <p><strong>Name:</strong><br><?php echo htmlspecialchars($order['customer_name']); ?></p>
                                    <p><strong>Shipping Address:</strong><br>
                                        <?php echo htmlspecialchars($order['customer_address']); ?><br>
                                        <?php echo htmlspecialchars($order['customer_city']); ?>
                                    </p>
                                    <p><strong>Contact:</strong><br>
                                        Email: <?php echo htmlspecialchars($order['customer_email']); ?><br>
                                        Phone: <?php echo htmlspecialchars($order['customer_phone']); ?>
                                    </p>
                                    <hr>
                                    <p><strong>Payment Method:</strong><br>
                                        <!-- CORRECTED: This now checks if the value is not empty -->
                                        <?php echo !empty($order['payment_method']) ? htmlspecialchars($order['payment_method']) : 'N/A'; ?>
                                    </p>
                                     <div class="content-card">
                                <div class="card-header"><h3>Update Status</h3></div>
                                <div class="card-body">
                                    <form action="admin/update-order-status.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Order Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="Pending" <?php if($order['payment_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                <option value="Processing" <?php if($order['payment_status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                                <option value="Shipped" <?php if($order['payment_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                                <option value="Completed" <?php if($order['payment_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                <option value="Cancelled" <?php if($order['payment_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                                    </form>
                                </div>
                            </div>
                                    <hr>
                                    <h4><strong>Total: $<?php echo number_format($order['total_amount'], 2); ?></strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
// JavaScript to render the main chart with real data
const ctx = document.getElementById('mainChart').getContext('2d');
const mainChart = new Chart(ctx, {
    type: 'line', // Area chart
    data: {
        labels: <?php echo json_encode($chart_labels); ?>, // Use real dates from PHP
        datasets: [{
            label: 'Orders per Day',
            data: <?php echo json_encode($chart_order_data); ?>, // Use real order counts from PHP
            backgroundColor: 'rgba(173, 125, 82, 0.2)',
            borderColor: 'rgba(173, 125, 82, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
    }
});
</script>
</body>
</html>
<?php $conn->close(); ?>