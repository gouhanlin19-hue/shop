<?php

session_start();

include(__DIR__ . "/config/db.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

$limit = 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$stmt = $conn->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-card {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }

        .product-card h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .price {
            color: green;
            font-weight: bold;
        }

        .pagination {
            text-align: center;
            margin-top: 30px;
        }

        .pagination a {
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div style="text-align:center; margin-bottom:20px;">
    <?php if (isset($_SESSION["username"])): ?>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?> 
        (<?php echo htmlspecialchars($_SESSION["role"]); ?>)</p>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>

    <h1>Our Products</h1>

    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Seller ID:</strong> <?php echo htmlspecialchars($product['seller_id']); ?></p>
                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
                <p>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> |
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </p>
            <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    </div>

</body>
</html>