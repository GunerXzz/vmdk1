<?php
session_start();

// --- 1. Database Connection ---
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "vmdk_db";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cart_items = [];
$total_price = 0;

// --- 2. Check if the cart exists and is not empty ---
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $product_ids);
    
    if (!empty($ids_string)) {
        $sql = "SELECT id, name, price, image_path FROM products WHERE id IN ($ids_string)";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['id'];
                $quantity = $_SESSION['cart'][$product_id]['quantity'];
                $row['quantity'] = $quantity;
                $row['subtotal'] = $row['price'] * $quantity;
                $cart_items[] = $row;
                $total_price += $row['subtotal'];
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | VmdK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/cart.css"> 
    <script src="js/SmoothScroll.js"></script>
    <script src="js/cart-ajax.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=add_shopping_cart" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Koulen&family=Luckiest+Guy&family=Playball&family=Rubik:ital,wght@0,300..900;1,300..900&family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/jquery3.6.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/SmoothScroll.js"></script>
    <script src="js/script.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="page-header navp">
        <div class="container">
            <h1>Shopping Cart</h1>
        </div>
    </div>

    <main class="cart-section navp">
        <div class="container">

            <div class="row">
                <div class="col-lg-8">
                    <?php if (!empty($cart_items)): ?>
                        <div class="table-responsive">
                            <table class="table cart-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr data-id="<?php echo $item['id']; ?>">
                                            <td><img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-img"></td>
                                            <td><h2 class="h5 product-title-cart"><?php echo htmlspecialchars($item['name']); ?></h2></td>
                                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <div class="input-group quantity-container">
                                                    <button class="btn btn-outline-secondary decrease-btn" type="button">&minus;</button>
                                                    <input type="text" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" data-id="<?php echo $item['id']; ?>">
                                                    <button class="btn btn-outline-secondary increase-btn" type="button">&plus;</button>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">$<?php echo number_format($item['subtotal'], 2); ?></td>
                                            <td><button class="remove-item-btn" data-id="<?php echo $item['id']; ?>">&times;</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="cart-empty-message">
                            <p>Your cart is empty. <a href="shop.php">Go shopping!</a></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3 class="summary-title">Cart Totals</h3>
                        <div class="summary-item">
                            <span class="label">Subtotal</span>
                            <span class="value" id="cart-total-price">$<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <hr class="my-3">
                        <div class="summary-item total">
                            <span class="label">Total</span>
                            <span class="value" id="cart-grand-total">$<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <div class="d-grid">
                            <a href="checkout.php" class="btn btn-primary btn-lg mt-4 checkout-btn">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-auto pt-5 pb-4">
        </footer>

    <script src="js/jquery3.6.js"></script>
    <script src="js/cart-quantity.js"></script> 
</body>
</html>