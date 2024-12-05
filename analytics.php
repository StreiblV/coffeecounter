<?php
require_once 'sessiondata.php';

// Fetch current user's daily coffee history
$dailyHistory = [];
if ($userId) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                DATE(timestamp) as date, 
                SUM(
                    CASE 
                        WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
                        WHEN e.type = 'coke' THEN 1
                        ELSE 0
                    END
                ) as total_points
            FROM 
                coffee_entries 
            WHERE 
                user_id = :user_id 
            GROUP BY 
                DATE(timestamp) 
            ORDER BY 
                date DESC;
        ");
        $stmt->execute([':user_id' => $userId]);
        $dailyHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle SQL error gracefully
        echo "Error: " . $e->getMessage();
        $dailyHistory = [];
    }
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
// Export user's coffee data
if ($userId && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['export'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="coffee_history.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Date & Time', 'Energy Boost']); // Updated column name

        // Updated query to fetch the type of entry
        $stmt = $pdo->prepare("
            SELECT DATE_FORMAT(timestamp, '%Y-%m-%d %H:%i') as datetime, type
            FROM coffee_entries
            WHERE user_id = :user_id
            ORDER BY timestamp DESC
        ");
        $stmt->execute([':user_id' => $userId]);

        // Fetch rows and include type in the output
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [$row['datetime'], $row['type']]); // Include type
        }

        fclose($output);
        exit;
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
	<form method="POST">
        <button id="btn-secondary" type="submit" name="export" onclick="confirmRemoval(event)">Export</button>
	</form>
</body>
</html>