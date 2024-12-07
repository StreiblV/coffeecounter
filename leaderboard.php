<?php
require_once 'sessiondata.php';

// Fetch Daily Consume
$stmt = $pdo->query("
    SELECT 
		u.username, 
		SUM(
			CASE 
				WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
				WHEN e.type = 'coke' THEN 1
				ELSE 1
			END
		) AS total_points
	FROM 
		coffee_users u
	LEFT JOIN 
		coffee_entries e 
	ON 
		u.id = e.user_id 
	WHERE 
		DATE(e.timestamp) = CURDATE()
	GROUP BY 
		u.username 
	ORDER BY 
		total_points DESC, u.username
	LIMIT 10;


");
$dailyLeaderboard = $stmt->fetchAll();

// Fetch Average Daily Consume
$stmt = $pdo->query("
	SELECT 
		u.username, 
		ROUND(
			SUM(
				CASE 
					WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
					WHEN e.type = 'coke' THEN 1
					ELSE 0
				END
			) / COUNT(DISTINCT DATE(e.timestamp)), 2
		) AS avg_daily
	FROM 
		coffee_users u
	LEFT JOIN 
		coffee_entries e 
	ON 
		u.id = e.user_id 
	GROUP BY 
		u.username 
	ORDER BY 
		avg_daily DESC, u.username
	LIMIT 10;
");
$averageLeaderboard = $stmt->fetchAll();

// Fetch Total Consume
$stmt = $pdo->query("
    SELECT 
        u.username, 
        SUM(
            CASE 
                WHEN e.type IN ('coffee', 'wildkraut', 'energydrink') THEN 3
                WHEN e.type = 'coke' THEN 1
                ELSE 0
            END
        ) AS total_points
    FROM 
        coffee_users u
    LEFT JOIN 
        coffee_entries e 
    ON 
        u.id = e.user_id 
    GROUP BY 
        u.username 
    ORDER BY 
        total_points DESC, u.username
    LIMIT 10;
");
$totalLeaderboard = $stmt->fetchAll();

// Fetch Top Coffee Consume
$stmt = $pdo->query("
    SELECT u.username
	FROM coffee_users u
	LEFT JOIN coffee_entries e ON u.id = e.user_id
	WHERE e.type = 'coffee' AND DATE(e.timestamp) = CURDATE()
	GROUP BY u.username
	ORDER BY COUNT(e.id) DESC
	LIMIT 1;
");
$stmt->execute();
$top_coffee = $stmt->fetchColumn() ?? 'Nobody';

// Fetch Top Wildkraut Consume
$stmt = $pdo->query("
    SELECT u.username
	FROM coffee_users u
	LEFT JOIN coffee_entries e ON u.id = e.user_id
	WHERE e.type = 'wildkraut' AND DATE(e.timestamp) = CURDATE()
	GROUP BY u.username
	ORDER BY COUNT(e.id) DESC
	LIMIT 1;
");
$stmt->execute();
$top_wildkraut = $stmt->fetchColumn() ?? 'Nobody';

// Fetch Top Energydrink Consume
$stmt = $pdo->query("
    SELECT u.username
	FROM coffee_users u
	LEFT JOIN coffee_entries e ON u.id = e.user_id
	WHERE e.type = 'energydrink' AND DATE(e.timestamp) = CURDATE()
	GROUP BY u.username
	ORDER BY COUNT(e.id) DESC
	LIMIT 1;
");
$stmt->execute();
$top_energydrink = $stmt->fetchColumn() ?? 'Nobody';

// Fetch Top Coke Consume
$stmt = $pdo->query("
    SELECT u.username
	FROM coffee_users u
	LEFT JOIN coffee_entries e ON u.id = e.user_id
	WHERE e.type = 'coke' AND DATE(e.timestamp) = CURDATE()
	GROUP BY u.username
	ORDER BY COUNT(e.id) DESC
	LIMIT 1;
");
$stmt->execute();
$top_coke = $stmt->fetchColumn() ?? 'Nobody';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="css/slidestyle.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>Leaderboard</h1>
	<h2>Today's Top Coffee Consumer</h2>
	<p>Coffee: <b><?php echo htmlspecialchars($top_coffee) ?></b></p>
	<p>Wildkraut: <b><?php echo htmlspecialchars($top_wildkraut) ?></b></p>
	<p>Energydrink: <b><?php echo htmlspecialchars($top_energydrink) ?></b></p>
	<p>Coke: <b><?php echo htmlspecialchars($top_coke) ?></b></p>

	<h1>Top 10</h1>
    <!-- Slider Container -->
    <div class="slider-container">
        <div class="slider">
            <!-- Slide 1: Daily Consume -->
            <div class="slide">
                <h2>Today's Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($dailyLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['total_points']; ?> Energy Level<?php echo $entry['total_points'] !== 1 ? 's' : ''; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Slide 2: Average Daily Consume -->
            <div class="slide">
                <h2>Average Daily Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($averageLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['avg_daily']; ?> Energy Level<?php echo $entry['avg_daily'] !== 1 ? 's' : ''; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Slide 3: Total Consume -->
            <div class="slide">
                <h2>Total Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($totalLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['total_points']; ?> Energy Level<?php echo $entry['total_points'] !== 1 ? 's' : ''; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <button class="slider-btn left">&larr;</button>
        <button class="slider-btn right">&rarr;</button>
    </div>

    <script>
        // JavaScript for Slider
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.slider');
            const slides = document.querySelectorAll('.slide');
            const leftButton = document.querySelector('.slider-btn.left');
            const rightButton = document.querySelector('.slider-btn.right');

            let currentSlide = 0;

            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            leftButton.addEventListener('click', function () {
                currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
                updateSlider();
            });

            rightButton.addEventListener('click', function () {
                currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
                updateSlider();
            });
        });
    </script>
</body>
</html>