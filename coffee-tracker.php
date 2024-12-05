<?php
require_once 'sessiondata.php';

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
    // Check for add type
    if (isset($_POST['addCoffee'])) {
        $addtype = 'coffee';
    } elseif (isset($_POST['addWildkraut'])) {
        $addtype = 'wildkraut';
    } elseif (isset($_POST['addEnergyDrink'])) {
        $addtype = 'energydrink';
    }

    // Add entry if a type is set
    if (isset($addtype)) {
        $stmt = $pdo->prepare("INSERT INTO coffee_entries (user_id, type) VALUES (:user_id, :addtype)");
        $stmt->execute([
            ':user_id' => $userId,
            ':addtype' => $addtype
        ]);
    }

    // Check for remove type
    if (isset($_POST['removeCoffee'])) {
        $removetype = 'coffee';
    } elseif (isset($_POST['removeWildkraut'])) {
        $removetype = 'wildkraut';
    } elseif (isset($_POST['removeEnergyDrink'])) {
        $removetype = 'energydrink';
    }

    // Handle remove operation if a type is set
    if (isset($removetype)) {
		$stmt = $pdo->prepare("
			DELETE coffee_entries 
			FROM coffee_entries
			INNER JOIN (
				SELECT id 
				FROM coffee_entries 
				WHERE user_id = :user_id AND type = :removetype
				ORDER BY timestamp DESC 
				LIMIT 1
			) as target
			ON coffee_entries.id = target.id
		");
		$stmt->execute([
			':user_id' => $userId,
			':removetype' => $removetype
		]);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <script>
        function confirmRemoval(event) {
            if (!confirm("Are you sure you want to remove it?")) {
                event.preventDefault();
            }
        }

        async function genAiSummary(event) {
            event.target.innerText = "Generating...";
            event.target.disabled = true;

            let text = '';
            const response = await fetch('/ai-summary.php');
            if (response.ok) {
                text = await response.text();
            } else {
                text = `Unexpected response: ${response}`;
            }

            const overview = document.getElementById('ai-overview');
            const span = document.createElement('div');
            span.innerText = text;
            overview.appendChild(span);
            event.target.remove();
        }
    </script>
</head>
<body>
	<?php include 'navbar.php'; ?>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <div class="todays-count-box">
        <p>
            Today your caffeine consumption adds up to <span><?php echo $todaysCount; ?></span> Energy Level<?php echo $todaysCount !== 1 ? 's' : ''; ?>.
        </p>
    </div>
    <form method="POST">
		<button id="btn-primary" type="submit" name="addCoffee">Add Cup</button>
		<button id="btn-primary" type="submit" name="addWildkraut">Add Wildkraut</button>
        <button id="btn-primary" type="submit" name="addEnergyDrink">Add Energy Drink</button>
    </form>
	<div class="ai-box <?php if (!isset($OPENAI_API_KEY)) { echo "hidden"; } ?>">
        <h2>✨ AI Overview ✨</h2>
        <p id="ai-overview">
            <button id="btn-primary" onclick=genAiSummary(event)>Generate a customized™ AI summary</button>
        </p>
    </div>
	<hr>
    <form method="POST">
        <button id="btn-secondary" type="submit" name="removeCoffee" onclick="confirmRemoval(event)">Remove Cup</button>
		<button id="btn-secondary" type="submit" name="removeWildkraut" onclick="confirmRemoval(event)">Remove Wildkraut</button>
		<button id="btn-secondary" type="submit" name="removeEnergyDrink" onclick="confirmRemoval(event)">Remove Energy Drink</button>
    </form>
</body>
</html>