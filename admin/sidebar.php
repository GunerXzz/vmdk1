<?php
// This PHP code automatically figures out the correct path for the links.
$path_prefix = (basename($_SERVER['SCRIPT_FILENAME']) === 'admin.php') ? 'admin/' : '';
$base_path = (basename($_SERVER['SCRIPT_FILENAME']) === 'admin.php') ? '' : '../';
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <a class="navbar-brand logo-font" href="<?php echo $base_path; ?>index.php">VmdK<span>.</span></a>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_path; ?>admin.php?page=dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_path; ?>admin.php?page=add_product">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_path; ?>admin.php?page=manage_products">
                <i class="fas fa-box-open"></i> Manage Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_path; ?>admin.php?page=orders">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link" href="<?php echo $base_path; ?>index.php"><i class="fas fa-home"></i> Back to site</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $base_path; ?>logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </li>
    </ul>
</aside>
