<?php
session_start();
include(__DIR__ . "/config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":username" => $username,
        ":password" => $password
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        header("Location: products.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 350px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input {
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
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Login</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

</body>
</html>