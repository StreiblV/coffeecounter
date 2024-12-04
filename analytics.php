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

// Fetch current user's daily coffee history
$dailyHistory = [];
if ($userId) {
    $stmt = $pdo->prepare("
        SELECT DATE(timestamp) as date, COUNT(*) as count 
        FROM coffee_entries 
        WHERE user_id = :user_id 
        GROUP BY DATE(timestamp) 
        ORDER BY date DESC
    ");
    $stmt->execute([':user_id' => $userId]);
    $dailyHistory = $stmt->fetchAll();
}

// Fetch coffee entries for the current day, grouped by time
$todayData = [];
$todaysCount = 0;
if ($userId) {
    $stmt = $pdo->prepare("
        SELECT DATE_FORMAT(timestamp, '%H:%i') as time, COUNT(*) as count
        FROM coffee_entries
        WHERE user_id = :user_id AND DATE(timestamp) = CURDATE()
        GROUP BY time
        ORDER BY time ASC
    ");
    $stmt->execute([':user_id' => $userId]);
    $entries = $stmt->fetchAll();

    // Prepare full timeline from 00:00 to 23:59
    $todayData = array_fill_keys(
        array_map(
            fn($h) => sprintf('%02d:00', $h), // Full hour time slots
            range(0, 23)
        ),
        0
    );

    // Populate counts from database results and calculate today's total count
    foreach ($entries as $entry) {
        $todayData[$entry['time']] = (int)$entry['count'];
        $todaysCount += (int)$entry['count']; // Increment today's total count
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
    <?php include 'hourly-consume-diagram.php'; ?>
    <hr>
    <h2>Your Daily Caffeine History</h2>
    <ul>
        <?php foreach ($dailyHistory as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['date']); ?></strong>: <?php echo $entry['count']; ?> Energy Level<?php echo $entry['count'] !== 1 ? 's' : ''; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>