<?php
session_start();
include(__DIR__ . "/config/db.php");

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// only admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("Access denied. Admin only.");
}

$message = "";

$sellersSql = "SELECT * FROM sellers";
$sellersStmt = $conn->query($sellersSql);
$sellers = $sellersStmt->fetchAll(PDO::FETCH_ASSOC);

// ===== submit table =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $seller_id = $_POST["seller_id"];

    try {
        $sql = "INSERT INTO products (name, price, description, image, seller_id)
                VALUES (:name, :price, :description, :image, :seller_id)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":price" => $price,
            ":description" => $description,
            ":image" => $image,
            ":seller_id" => $seller_id
        ]);

        header("Location: products.php");
            exit();
    } catch (PDOException $e) {
        $message = "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<!-- Back button -->
<a href="javascript:history.back()" class="back-button">← Back</a>

<h1 class="page-title">Add New Product</h1>

<?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="">

    <input type="text" name="name" placeholder="Product name" required>

    <input type="number" step="0.01" name="price" placeholder="Price" required>

    <textarea name="description" placeholder="Description" required></textarea>

    <input type="text" name="image" placeholder="Image filename">

    <select name="seller_id" required>
        <option value="">Select a seller</option>
        <?php foreach ($sellers as $seller): ?>
            <option value="<?php echo $seller['id']; ?>">
                <?php echo htmlspecialchars($seller['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Add Product</button>

</form>

</body>
</html>