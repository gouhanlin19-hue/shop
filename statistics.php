<?php
session_start();
include(__DIR__ . "/config/db.php");

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 1. Total number of products
$totalProductsSql = "SELECT COUNT(*) AS total_products FROM products";
$totalProductsStmt = $conn->query($totalProductsSql);
$totalProducts = $totalProductsStmt->fetch(PDO::FETCH_ASSOC);

// 2. Sum of all product prices
$totalPriceSql = "SELECT SUM(price) AS total_price FROM products";
$totalPriceStmt = $conn->query($totalPriceSql);
$totalPrice = $totalPriceStmt->fetch(PDO::FETCH_ASSOC);

// 3. Average product price
$avgPriceSql = "SELECT AVG(price) AS avg_price FROM products";
$avgPriceStmt = $conn->query($avgPriceSql);
$avgPrice = $avgPriceStmt->fetch(PDO::FETCH_ASSOC);

// 4. Products per seller
$groupBySql = "
    SELECT sellers.name AS seller_name, COUNT(products.id) AS product_count
    FROM sellers
    LEFT JOIN products ON sellers.id = products.seller_id
    GROUP BY sellers.id, sellers.name
";
$groupByStmt = $conn->query($groupBySql);
$sellerStats = $groupByStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<a href="javascript:history.length > 1 ? history.back() : 'products.php'" class="back-button">
    ← Back
</a>

<h1 class="page-title">Shop Statistics</h1>

<div class="stats-box">
    <p><strong>Total number of products:</strong> <?php echo htmlspecialchars($totalProducts['total_products']); ?></p>
    <p><strong>Total price:</strong> $<?php echo number_format($totalPrice['total_price'], 2); ?></p>
    <p><strong>Average price:</strong> $<?php echo number_format($avgPrice['avg_price'], 2); ?></p>
</div>

<h2>Products per Seller</h2>

<table>
    <tr>
        <th>Seller</th>
        <th>Number of Products</th>
    </tr>

    <?php foreach ($sellerStats as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['seller_name']); ?></td>
            <td><?php echo htmlspecialchars($row['product_count']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>