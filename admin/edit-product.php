<?php
// Start the session to access login data.
session_start();

// --- Security Check ---
// This ensures only logged-in admins can see this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Check if a product ID was provided in the URL.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = "Error: Invalid product ID.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../admin.php?page=manage_products");
    exit;
}

$product_id = (int)$_GET['id'];

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- Fetch the existing product data from the database ---
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// If no product was found with that ID, redirect back.
if (!$product) {
    $_SESSION['message'] = "Error: Product not found.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../admin.php?page=manage_products");
    exit;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product | VmdK Admin</title>
    <!-- Add your standard admin CSS and font links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css"> <!-- Link to your dedicated admin CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
            <div class="container-fluid">
                <div class="header-bar">
                    <h1 class="page-title">Edit Product</h1>
                </div>
                <div class="content-card">
                    <div class="card-header"><h3>Product Details for '<?php echo htmlspecialchars($product['name']); ?>'</h3></div>
                    <div class="card-body">
                        <form action="process-update-product.php" method="POST" enctype="multipart/form-data">
                            <!-- Hidden input to send the product ID with the form -->
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="product_description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                    <label for="productCategory" class="form-label">Category</label>
                                    <select class="form-select" id="productCategory" name="product_category" required>
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="chair">Chair</option>
                                        <option value="table">Table</option>
                                        <option value="combo">Combo</option>
                                    </select>
                                </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="productPrice" class="form-label">Price ($)</label>
                                    <input type="number" class="form-control" id="productPrice" name="product_price" step="0.01" value="<?php echo $product['price']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="productStock" class="form-label">Stock Quantity</label>
                                    <input type="number" class="form-control" id="productStock" name="product_stock" value="<?php echo $product['stock']; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Current Image</label>
                                <div>
                                    <?php if (!empty($product['image_path'])): ?>
                                        <img src="../<?php echo htmlspecialchars($product['image_path']); ?>" alt="Current Image" style="max-width: 100px; border-radius: 8px; margin-bottom: 10px;">
                                    <?php else: ?>
                                        <p class="text-muted">No image currently set.</p>
                                    <?php endif; ?>
                                </div>
                                <label for="productImage" class="form-label mt-2">Upload New Image (Optional)</label>
                                <input class="form-control" type="file" id="productImage" name="product_image" accept="image/*">
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="../admin.php?page=manage_products" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
