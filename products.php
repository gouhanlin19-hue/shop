<?php
session_start();
include(__DIR__ . "/config/db.php");

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 6;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Total count（search）
if ($search != '') {
    $totalStmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE name LIKE :search");
    $totalStmt->bindValue(':search', '%' . $search . '%');
    $totalStmt->execute();
    $totalProducts = $totalStmt->fetchColumn();
} else {
    $totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
}

// Main query
if ($search != '') {
    $stmt = $conn->prepare("
        SELECT products.*, sellers.name AS seller_name
        FROM products
        LEFT JOIN sellers ON products.seller_id = sellers.id
        WHERE products.name LIKE :search
        LIMIT $limit OFFSET $offset
    ");
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
} else {
    $stmt = $conn->query("
        SELECT products.*, sellers.name AS seller_name
        FROM products
        LEFT JOIN sellers ON products.seller_id = sellers.id
        LIMIT $limit OFFSET $offset
    ");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<a href="javascript:history.back()" class="back-button">← Back</a>

<h1 class="page-title">Our Products</h1>

<form method="GET" class="search-box">
    <input 
        type="text" 
        name="search" 
        placeholder="Search products..." 
        value="<?php echo htmlspecialchars($search); ?>"
    >
    <button type="submit">Search</button>
</form>

<div class="container">

    <div class="products-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" width="200">
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>
                    <strong>Seller:</strong>
                    <?php echo htmlspecialchars($product['seller_name'] ?? 'Unknown'); ?>
                </p>

                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
                    <div class="card-actions">
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>"
                           onclick="return confirm('Are you sure?');">
                           Delete
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
        <?php endif; ?>

        <?php if ($offset + $limit < $totalProducts): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
        <?php endif; ?>
    </div>

</div>

<?php include("footer.php"); ?>

</body>
</html>