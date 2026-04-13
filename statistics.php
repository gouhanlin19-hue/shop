<?php
include(__DIR__ . "/config/db.php");

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

// 4. Number of products per seller
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
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1, h2 {
            text-align: center;
        }

        .stats-box {
            width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }

        table {
            width: 500px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <h1>Shop Statistics</h1>

    <div class="stats-box">
        <p><strong>Total number of products:</strong> <?php echo htmlspecialchars($totalProducts['total_products']); ?></p>
        <p><strong>Sum of all product prices:</strong> $<?php echo number_format($totalPrice['total_price'], 2); ?></p>
        <p><strong>Average product price:</strong> $<?php echo number_format($avgPrice['avg_price'], 2); ?></p>
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