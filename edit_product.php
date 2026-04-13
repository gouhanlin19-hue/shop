<?php
session_start();
include(__DIR__ . "/config/db.php");

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("Access denied. Admin only.");
}

if (!isset($_GET['id'])) {
    die("Product ID is missing.");
}

$id = (int)$_GET['id'];
$message = "";

// getting products info
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([":id" => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// update database if formula is submited
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $seller_id = $_POST["seller_id"];

    $updateSql = "UPDATE products 
                  SET name = :name, price = :price, description = :description, image = :image, seller_id = :seller_id
                  WHERE id = :id";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ":name" => $name,
        ":price" => $price,
        ":description" => $description,
        ":image" => $image,
        ":seller_id" => $seller_id,
        ":id" => $id
    ]);

    $message = "Product updated successfully!";

    // get the latest data after updating
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea {
            padding: 10px;
            font-size: 16px;
        }

        button {
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
        }

        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Edit Product</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
        <input type="number" name="seller_id" value="<?php echo htmlspecialchars($product['seller_id']); ?>" required>
        <button type="submit">Update Product</button>
    </form>

</body>
</html>