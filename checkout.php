<?php
session_start();

// --- Gatekeeper: Redirect if not logged in ---
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "vmdk_db");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// --- Fetch Logged-in User's Data ---
$user_id = $_SESSION['user_id'];
$user_result = $conn->query("SELECT firstname, lastname, email FROM users WHERE id = $user_id");
$user_data = $user_result->fetch_assoc();
$user_firstname = $user_data['firstname'] ?? '';
$user_lastname = $user_data['lastname'] ?? '';
$user_email = $user_data['email'] ?? '';

// --- Fetch Cart Data ---
$cart_items = [];
$total_price = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $product_ids);
    if (!empty($ids_string)) {
        $sql = "SELECT id, name, price FROM products WHERE id IN ($ids_string)";
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
    <title>Checkout | VmdK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="page-header navp"><div class="container"><h1>Checkout</h1></div></div>

    <main class="checkout-section">
        <div class="container">
            <!-- The form now wraps around BOTH columns -->
            <form action="admin/place-order.php" method="POST" id="billingForm">
                <div class="row">
                    <div class="col-md-7">
                        <div class="billing-details-card">
                            <h3 class="card-title">Billing Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user_firstname); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user_lastname); ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3"><label for="address" class="form-label">Address</label><input type="text" class="form-control" id="address" name="address" required></div>
                            <div class="mb-3"><label for="city" class="form-label">City / Province</label><input type="text" class="form-control" id="city" name="city" required></div>
                            <div class="mb-3"><label for="phone" class="form-label">Phone</label><input type="tel" class="form-control" id="phone" name="phone" required></div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="order-summary-card">
                            <h3 class="card-title">Your Order</h3>
                            <ul class="order-summary-list">
                                <?php foreach ($cart_items as $item): ?>
                                    <li>
                                        <?php echo htmlspecialchars($item['name']); ?>
                                        <span>x <?php echo $item['quantity']; ?></span>
                                        <strong>$<?php echo number_format($item['subtotal'], 2); ?></strong>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="order-total">
                                <strong>Total</strong>
                                <strong>$<?php echo number_format($total_price, 2); ?></strong>
                            </div>
                            
                            <!-- MOVED PAYMENT OPTIONS INSIDE THE FORM -->
                            <div class="payment-methods mt-4">
                                <h4 class="payment-options-title">Payment Method</h4>
                                <div class="payment-option">
                                    <input type="radio" id="pay-aba" name="payment_method" value="ABA Bank" checked>
                                    <label for="pay-aba"><img src="images/aba.jpg" alt="ABA Bank" class="payment-logo"><span class="payment-name">ABA Bank</span><span class="payment-description">Scan KHQR to pay</span></label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="pay-acleda" name="payment_method" value="ACLEDA Bank">
                                    <label for="pay-acleda"><img src="images/logo_txt.png" alt="ACLEDA Bank" class="payment-logo"><span class="payment-name">ACLEDA Bank</span><span class="payment-description">Scan KHQR to pay</span></label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="pay-card" name="payment_method" value="Credit/Debit Card">
                                    <label for="pay-card"><img src="https://placehold.co/100x30/CCCCCC/FFFFFF?text=VISA" alt="Credit Card" class="payment-logo"><span class="payment-name">Credit/Debit Card</span><span class="payment-description">Visa, Mastercard</span></label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="pay-cod" name="payment_method" value="Cash on Delivery">
                                    <label for="pay-cod"><img src="https://placehold.co/100x30/444444/FFFFFF?text=Cash" alt="Cash on Delivery" class="payment-logo"><span class="payment-name">Cash on Delivery</span><span class="payment-description">Pay upon arrival</span></label>
                                </div>

                                <div id="qr-code-display">
                                    <img src="images/qr.jpg" alt="QR Code">
                                    <p>Please scan the QR code with your banking app to complete the payment.</p>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" form="billingForm" class="btn btn-primary btn-lg mt-4 checkout-btn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- Your standard footer here -->
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const qrDisplay = document.getElementById('qr-code-display');

            function toggleQrDisplay() {
                const selectedValue = document.querySelector('input[name="payment_method"]:checked').value;
                if (selectedValue === 'ABA Bank' || selectedValue === 'ACLEDA Bank') {
                    qrDisplay.style.display = 'block';
                } else {
                    qrDisplay.style.display = 'none';
                }
            }

            paymentRadios.forEach(radio => radio.addEventListener('change', toggleQrDisplay));
            
            toggleQrDisplay();
        });
    </script>
</body>
</html>
