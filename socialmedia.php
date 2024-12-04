<?php
session_start();

// Include database connection
require_once 'db.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    //header("Location: index.php?action=login");
    //exit;
    echo $_SESSION['username'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>
	<?php include 'navbar.php'; ?>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <h3>Something amazing is in Production! Wait for it~</h3>
</body>
</html>