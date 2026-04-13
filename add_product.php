<?php
session_start();
include(__DIR__ . "/config/db.php");

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("Access denied. Admin only.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $seller_id = $_POST["seller_id"];

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

    $message = "Product added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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

    <h1>Add New Product</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Product name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="text" name="image" placeholder="Image filename">
        <input type="number" name="seller_id" placeholder="Seller ID" required>
        <button type="submit">Add Product</button>
    </form>

</body>
</html>