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
    <?php include 'header.php'; ?>
	<title>Register for Caffinity</title>
</head>
<body>
    <main>
        <h2>Register</h2>
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
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
</body>
</html>