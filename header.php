<?php session_start(); ?>
<header>
    <nav class="fixed-top navbar nav-bar-bg navbar navbar-expand-lg text-uppercase fs-6 p-3 align-items-center navbar-expand-md custom-navbar" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand logo-font hover-underline" href="index.php">VmdK<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 gap-md-3 pe-3">
                    <li class="nav-item"><a class="nav-link hover-underline" href="index.php#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link hover-underline" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link hover-underline" href="about-us.php">About us</a></li>
                    <li class="nav-item"><a class="nav-link hover-underline" href="index.php#services">Services</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- If user IS logged in -->
                        <li class="nav-item dropdown user-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="images/user.png" alt="User">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <!-- UPDATED: This now links to profile.php -->
                                <li><a class="dropdown-item" href="profile.php"><?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?></a></li>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                    <li><a class="dropdown-item" href="admin.php">Admin Dashboard</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- If user is NOT logged in -->
                        <li class="nav-item user-dropdown">
                            <a class="nav-link" href="login.php"><img src="images/user.png" alt="Login"></a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item cart-icon"><a class="nav-link" href="cart.php"><img src="images/cart.png"></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
