<?php
session_start();
require_once 'db.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM coffee_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // Regenerate session to prevent fixation
        $_SESSION['username'] = $username;
        header("Location: coffee-tracker.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Coffee Counter</title>
    <link rel="stylesheet" href="style.css">
	
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
	<link rel="manifest" href="/favicon_io/site.webmanifest">
</head>
<body>
    <main>
        <h2>Login</h2>
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
            
            <button id="btn-primary" type="submit">Login</button>
        </form>
        <p>No account yet? <a href="register.php">Register here</a>.</p>
    </main>
</body>
</html>