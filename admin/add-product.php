<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product | VmdK Admin</title>
    <!-- Add same head content as dashboard.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css"> <!-- Link to your dedicated admin CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        <main class="main-content">
            <div class="container-fluid">
                <div class="header-bar">
                    <h1 class="page-title">Add New Product</h1>
                </div>
                <div class="content-card">
                    <div class="card-header"><h3>Product Details</h3></div>
                    <div class="card-body">
                        <!-- The form will submit to your existing process-product.php script -->
                        <form action="process-product.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="product_description" rows="4"></textarea>
                            </div>
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
            </div>
        </main>
    </div>
</body>
</html>
