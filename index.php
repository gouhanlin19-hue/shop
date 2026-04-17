<?php
session_start();
include("config/db.php");

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$productCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$sellerCount = $conn->query("SELECT COUNT(*) FROM sellers")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<div class="hero">
    <h1>Online Shop</h1>
    <p>A simple PHP and MySQL web application for product management.</p>

    <p class="stats-info">
        📦 <?php echo $productCount; ?> Products |
        🏪 <?php echo $sellerCount; ?> Sellers
    </p>

    <div class="hero-links">
        <a href="products.php">View Products</a>
        <a href="sellers.php">View Sellers</a>
        <a href="statistics.php">View Statistics</a>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>