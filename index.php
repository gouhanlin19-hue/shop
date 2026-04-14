<?php
include("config/db.php");

$productCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$sellerCount = $conn->query("SELECT COUNT(*) FROM sellers")->fetchColumn();
?>

<p class="stats-info">
    📦 <?php echo $productCount; ?> Products |
    🏪 <?php echo $sellerCount; ?> Sellers
</p>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
    <div class="nav-left">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="statistics.php">Statistics</a>
    </div>

    <div class="nav-right">
        <a href="login.php">Login</a>
    </div>
</div>

<div class="hero">
    <h1>Online Shop</h1>
    <p>A simple PHP and MySQL web application for product management.</p>

    <div class="hero-links">
        <a href="products.php">View Products</a>
        <a href="statistics.php">View Statistics</a>
    </div>
</div>

<footer class="footer">
    <p>Online Shop Project © 2026 | SQL + PHP</p>
</footer>

</body>
</html>