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

$sql = "DELETE FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([":id" => $id]);

header("Location: products.php");
exit();
?>