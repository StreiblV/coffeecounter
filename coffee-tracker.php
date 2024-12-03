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

// Handle adding or removing coffee cups
if ($userId && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO coffee_entries (user_id) VALUES (:user_id)");
        $stmt->execute([':user_id' => $userId]);
    } elseif (isset($_POST['remove'])) {
        $stmt = $pdo->prepare("
            DELETE FROM coffee_entries 
            WHERE id = (
                SELECT id FROM (
                    SELECT id FROM coffee_entries 
                    WHERE user_id = :user_id 
                    ORDER BY timestamp DESC LIMIT 1
                ) as subquery
            )
        ");
        $stmt->execute([':user_id' => $userId]);
    }
    
    // Export user's coffee data
    if ($userId && isset($_POST['export'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="coffee_history.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Date & Time', 'Cups Consumed']);

        $stmt = $pdo->prepare("
            SELECT DATE_FORMAT(timestamp, '%Y-%m-%d %H:%i') as datetime
            FROM coffee_entries
            WHERE user_id = :user_id
            ORDER BY timestamp DESC
        ");
        $stmt->execute([':user_id' => $userId]);

        while ($row = $stmt->fetch()) {
            fputcsv($output, [$row['datetime'], 1]); // Each entry represents one cup
        }
        fclose($output);
        exit;
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Coffee Counter</title>
    <script>
        function confirmRemoval(event) {
            if (!confirm("Are you sure you want to remove a coffee cup?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <div class="todays-count-box">
        <p>
            Today your coffee consumption adds up to <span><?php echo $todaysCount; ?></span> cup<?php echo $todaysCount !== 1 ? 's' : ''; ?>.
        </p>
    </div>
    <form method="POST">
        <button id="btn-primary" type="submit" name="add">Add Cup</button>
    </form>
    <?php include 'hourly-consume-diagram.php'; ?>
    <hr>
    <h2>Your Daily Coffee History</h2>
    <ul>
        <?php foreach ($dailyHistory as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['date']); ?></strong>: <?php echo $entry['count']; ?> cups
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST">
        <button id="btn-secondary" type="submit" name="remove" onclick="confirmRemoval(event)">Remove Cup</button>
        <button id="btn-secondary" type="submit" name="export">Export Your Data</button>
    </form>
    <hr>
    <h2>Leaderboard</h2>
    <ul>
        <?php foreach ($leaderboard as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: <?php echo $entry['count']; ?> cups
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="logout.php">
        <button id="btn-secondary" type="submit">Logout</button>
    </form>
</body>
</html>