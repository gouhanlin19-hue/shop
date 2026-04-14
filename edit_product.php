<?php
session_start();
include(__DIR__ . "/config/db.php");

// Only admin can edit
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("Access denied. Admin only.");
}

// Check product ID
if (!isset($_GET['id'])) {
    die("Product ID is missing.");
}

$id = (int)$_GET['id'];
$message = "";

// Get current product data
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Get sellers for dropdown
$sellersStmt = $conn->query("SELECT * FROM sellers");
$sellers = $sellersStmt->fetchAll(PDO::FETCH_ASSOC);

// Update product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("
        UPDATE products
        SET name = ?, price = ?, description = ?, image = ?, seller_id = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST["name"],
        $_POST["price"],
        $_POST["description"],
        $_POST["image"],
        $_POST["seller_id"],
        $id
    ]);

    $message = "Product updated successfully!";

    // Reload updated product data
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
    <div class="nav-left">
        <a href="index.php">Home</a>
        <a href="sellers.php">Sellers</a>
        <a href="products.php">Products</a>
        <a href="statistics.php">Statistics</a>
        <a href="add_product.php">Add Product</a>
    </div>

    <div class="nav-right">
        <span class="nav-user">
            <?php echo htmlspecialchars($_SESSION["username"]); ?>
            (<?php echo htmlspecialchars($_SESSION["role"]); ?>)
        </span>
        <a href="logout.php">Logout</a>
    </div>
</div>

<a href="javascript:history.back()" class="back-button">← Back</a>

<h1 class="page-title">Edit Product</h1>

<?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($product['name']); ?>"
        required
    >

    <input
        type="number"
        step="0.01"
        name="price"
        value="<?php echo htmlspecialchars($product['price']); ?>"
        required
    >

    <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

    <input
        type="text"
        name="image"
        value="<?php echo htmlspecialchars($product['image']); ?>"
    >

    <select name="seller_id" required>
        <?php foreach ($sellers as $seller): ?>
            <option value="<?php echo $seller['id']; ?>"
                <?php if ($seller['id'] == $product['seller_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($seller['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Update Product</button>
</form>

<footer class="footer">
    <p>Online Shop Project © 2026 | SQL + PHP</p>
</footer>

</body>
</html>