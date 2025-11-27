<?php
// --- 1. Database Connection ---
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vmdk_db";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- 2. Fetch All Products from the Database ---
// UPDATED: Changed ORDER BY id DESC to ORDER BY id ASC
$sql = "SELECT id, name, price, category, image_path FROM products ORDER BY id ASC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | VmdK</title>
    <!-- Your existing CSS and JS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/shop-.css">
    <link rel="stylesheet" href="css/about-us.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="js/SmoothScroll.js"></script>

</head>
<body class="navp">

    <?php include 'header.php'; ?>

    <main class="shop-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h1 class="section-title">Our Collection</h1>
                    <p class="section-subtitle">Discover handcrafted pieces that bring elegance and comfort to your home.</p>
                </div>
            </div>

            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-12 col-md-4 col-lg-3 mb-4">
                            <div class="product-item-card">
                                <div class="product-image-container">
                                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="img-fluid product-thumbnail">
                                    
                                    <form action="admin/add-to-cart.php" method="POST" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="product-details">
                                    <h3 class="product-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p class="product-category"><?php echo htmlspecialchars($row['category']); ?></p>
                                    <strong class="product-price">$<?php echo number_format($row['price'], 2); ?></strong>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='text-center'>No products found. Please add some in the admin dashboard.</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <?php
    $conn->close();
    ?>
    <section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">Experience VmdK</h2>
        <p class="cta-text">Visit our showroom in the heart of Phnom Penh to see the quality and craftsmanship for yourself.</p>
        <a href="https://maps.app.goo.gl/me161V5is2UzuUDS9" class="btn btn-border-reveal">Find Us</a>
    </div>
</section>
</body>
</html>
