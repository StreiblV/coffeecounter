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

// Fetch leaderboard data
$stmt = $pdo->query("
    SELECT u.username, COUNT(e.id) as count 
    FROM coffee_users u
    LEFT JOIN coffee_entries e ON u.id = e.user_id 
    GROUP BY u.username 
    ORDER BY count DESC, u.username
");
$leaderboard = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>
	<?php include 'navbar.php'; ?>
    <h1>Monthly Leaderboard</h1>
    <ul>
        <?php foreach ($leaderboard as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: <?php echo $entry['count']; ?> Energy Level<?php echo $entry['count'] !== 1 ? 's' : ''; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>