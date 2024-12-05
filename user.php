<?php
session_start();

// Include database connection
require_once 'db.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: index.php?action=login");
    exit;
}

// Fetch user-specific data
$username = $_SESSION['username'];

// Fetch user ID if logged in
$userId = null;
if ($username) {
    $stmt = $pdo->prepare("SELECT id FROM coffee_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $userId = $stmt->fetchColumn();
}

// Handle updates
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $newUsername = trim($_POST['new_username']);
        $newPassword = trim($_POST['new_password']);

        if (!empty($newUsername)) {
            // Update username
            $stmt = $pdo->prepare("UPDATE coffee_users SET username = :new_username WHERE id = :user_id");
            $stmt->execute([':new_username' => $newUsername, ':user_id' => $userId]);
            $_SESSION['username'] = $newUsername;
            $username = $newUsername;
            $message = 'Username updated successfully.';
        }

        if (!empty($newPassword)) {
            // Hash the new password and update it
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE coffee_users SET password = :new_password WHERE id = :user_id");
            $stmt->execute([':new_password' => $hashedPassword, ':user_id' => $userId]);
            $message .= ' Password updated successfully.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>
	<?php include 'navbar.php'; ?>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
	
	<?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <h2>Update Username and Password</h2>
        <div class="form-grid">
            <label for="new_username">New Username:</label>
            <input type="text" id="new_username" name="new_username" value=<? echo htmlspecialchars($username); ?>>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password">

            <button id="btn-primary" type="submit" name="update">Update</button>
        </div>
    </form>
	
    <form method="POST" action="logout.php">
        <button id="btn-secondary" type="submit">Logout</button>
    </form>
</body>
</html>