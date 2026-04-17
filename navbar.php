<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="navbar">
    <div class="nav-left">
        <a href="index.php">Home</a>
        <a href="sellers.php">Sellers</a>
        <a href="products.php">Products</a>
        <a href="statistics.php">Statistics</a>
        <a href="add_product.php">Add Product</a>
        <a href="add_seller.php">Add Seller</a>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION["username"])): ?>
            <span class="nav-user">
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
                
            </span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</div>