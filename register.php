<?php
session_start();
require_once 'db.php';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO coffee_users (username, password) VALUES (:username, :password)");

        try {
            $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
            $_SESSION['username'] = $username;
            header("Location: coffee-tracker.php");
            exit;
        } catch (PDOException $e) {
            $error = "Username is already taken. Please choose another.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Coffee Counter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button id="btn-primary" type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
</body>
</html>