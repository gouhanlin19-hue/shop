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

// ===== submit form =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    try {
        $sql = "INSERT INTO sellers (name, description)
                VALUES (:name, :description)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":name" => $name,
            ":description" => $description
        ]);

        header("Location: sellers.php");
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
    <title>Add Seller</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("navbar.php"); ?>

<!-- Back button -->
<a href="javascript:history.back()" class="back-button">← Back</a>

<h1 class="page-title">Add New Seller</h1>

<?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="">

    <input type="text" name="name" placeholder="Seller name" required>

    <textarea name="description" placeholder="Description"></textarea>

    <button type="submit">Add Seller</button>

</form>

</body>
</html>