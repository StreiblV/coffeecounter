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
    <?php include 'header.php'; ?>
	<title>Login to Caffinity</title>
</head>
<body>
    <main>
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" class="form-grid">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>
			
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			
			<div></div> <!-- Empty div for grid alignment -->
			<button id="btn-primary" type="submit">Login</button>
		</form>
        <p>No account yet? <a href="register.php">Register here</a>.</p>
    </main>
</body>
</html>