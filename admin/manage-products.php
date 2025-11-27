<?php
include 'auth-check.php';
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$products_result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products | VmdK Admin</title>
    <!-- Add same head content as dashboard.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        <main class="main-content">
            <div class="container-fluid">
                <div class="header-bar">
                    <h1 class="page-title">Manage Products</h1>
                    <a href="add-product.php" class="btn btn-primary">Add New Product</a>
                </div>
                <div class="content-card">
                    <div class="card-body">
                        <table class="table table-hover table-admin">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($product = $products_result->fetch_assoc()): ?>
                                <tr>
                                    <td><img src="../<?php echo htmlspecialchars($product['image_path']); ?>" alt="" class="product-image-thumb"></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo $product['stock']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php $conn->close(); ?>
