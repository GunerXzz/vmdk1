<?php
session_start();

// If a user tries to access this page without placing an order, send them away.
if (!isset($_SESSION['last_order_id'])) {
    header('Location: index.php');
    exit;
}

$order_id = $_SESSION['last_order_id'];

// Clear the session variable so they can't see an old order ID if they refresh the page.
unset($_SESSION['last_order_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Order! | VmdK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .thank-you-section { text-align: center; padding: 6rem 0; background: #f7f6f4; }
        .thank-you-section .icon { font-size: 5rem; color: #ad7d52; margin-bottom: 1.5rem; }
        .thank-you-section h1 { font-family: "Cinzel Decorative", serif; }
        .thank-you-section p { font-size: 1.1rem; max-width: 600px; margin: 1rem auto; }
        .checkout-btn { background-color: #333; border-color: #333; }
        .checkout-btn:hover { background-color: #ad7d52; border-color: #ad7d52; }
    </style>
</head>
<body class="navp">

    <?php include 'header.php'; ?>
    
    <main class="thank-you-section">
        <div class="container">
            <div class="icon">&#10004;</div>
            <h1>Thank You!</h1>
            <p>Your order has been received and is now being processed. Puk Ah Sat Thai.</p>
            <p>Your order number is: <strong>#<?php echo $order_id; ?></strong></p>
            <a href="shop.php" class="btn btn-primary checkout-btn mt-3">Continue Shopping and Don't Thai to me</a>
        </div>
    </main>

    <!-- standard footer-->
    <footer class="mt-auto pt-5 pb-4">
       <footer id="contact" class="mt-auto pt-5 pb-4">
          <div class="container">
            <div class="row">
              <!-- Company Information -->
              <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">About vmdK</h5>
                <p class="small mb-0">
                  Inspired by Cambodia’s heritage, Vmdk blends traditional craftsmanship with modern design to create elegant, comfortable furniture. We support local artisans and deliver quality to homes across Cambodia.
                </p>
              </div>

              <!-- Quick Links -->
              <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled">
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#hero">
                          <i class="bi bi-house me-2"></i>Home
                        </a>
                      </li>
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#Shop">
                          <i class="bi bi-shop me-2"></i>Shop
                        </a>
                      </li>
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#about">
                          <i class="bi bi-info-circle me-2"></i>About Us
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled">
                      <li class="mb-2">
                        <a class="nav-link px-0" href="#services">
                          <i class="bi bi-gear me-2"></i>Services
                        </a>
                      </li>
                      <li>
                        <a class="nav-link px-0" href="#contact">
                          <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Social Media & Contact -->
              <div class="col-md-4">
                <h5 class="fw-bold mb-3">Contact & Follow Us</h5>
                <ul class="list-unstyled mb-3">
                  <li class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Phnom Penh, Cambodia</li>
                  <li class="mb-2"><i class="bi bi-telephone-fill me-2"></i>+855 12 345 678</li>
                  <li><i class="bi bi-envelope-fill me-2"></i>support@Vmdk.com.kh</li>
                </ul>
                <div class="footer-icons">
                  <a href="https://www.facebook.com" class="footer-icon me-3"><i class="fab fa-facebook-f fs-5"></i></a>
                  <a href="https://www.twitter.com" class="footer-icon me-3"><i class="fab fa-twitter fs-5"></i></a>
                  <a href="https://www.instagram.com" class="footer-icon me-3"><i class="fab fa-instagram fs-5"></i></a>
                  <a href="https://www.linkedin.com" class="footer-icon"><i class="fab fa-linkedin fs-5"></i></a>
                </div>
              </div>
            </div>

            <hr class="bg-secondary mt-4">

            <!-- Copyright -->
            <div class="row">
              <div class="col-12 text-center">
                <p class="mb-0 small text-secondary">&copy; 2025 VmdK Cambodia. All rights reserved.</p>
              </div>
            </div>
          </div>
        </footer>
    </footer>

</body>
</html>
