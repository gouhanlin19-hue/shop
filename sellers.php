<?php
session_start();
include(__DIR__ . "/config/db.php");

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch all sellers
$sql = "
SELECT s.*, COUNT(p.id) AS product_count
FROM sellers s
LEFT JOIN products p ON s.id = p.seller_id
GROUP BY s.id
";
$stmt = $conn->query($sql);
$sellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sellers</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<a href="javascript:history.back()" class="back-button">← Back</a>

<h1 class="page-title">Our Sellers</h1>

<div class="container">
    <div class="products-container">
        <?php foreach ($sellers as $seller): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($seller['name']); ?></h2>
                <p><?php echo htmlspecialchars($seller['description']); ?></p>
                <p><strong>
                     <?php echo $seller['product_count']; ?> 
                     <?php echo $seller['product_count'] == 1 ? 'product' : 'products'; ?>
                    </strong>
                </p>
                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
                    <div class="card-actions">
                        <a href="delete_seller.php?id=<?php echo $seller['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this seller?');">
                           Delete
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>