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

// Fetch Daily Consume
$stmt = $pdo->query("
    SELECT u.username, COUNT(e.id) AS count 
    FROM coffee_users u
    LEFT JOIN coffee_entries e ON u.id = e.user_id 
    WHERE DATE(e.timestamp) = CURDATE()
    GROUP BY u.username 
    ORDER BY count DESC, u.username
");
$dailyLeaderboard = $stmt->fetchAll();

// Fetch Average Daily Consume
$stmt = $pdo->query("
    SELECT u.username, 
           ROUND(COUNT(e.id) / COUNT(DISTINCT DATE(e.timestamp)), 2) AS avg_daily 
    FROM coffee_users u
    LEFT JOIN coffee_entries e ON u.id = e.user_id 
    GROUP BY u.username 
    ORDER BY avg_daily DESC, u.username
");
$averageLeaderboard = $stmt->fetchAll();

// Fetch Total Consume
$stmt = $pdo->query("
    SELECT u.username, COUNT(e.id) AS total 
    FROM coffee_users u
    LEFT JOIN coffee_entries e ON u.id = e.user_id 
    GROUP BY u.username 
    ORDER BY total DESC, u.username
");
$totalLeaderboard = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
	<link rel="stylesheet" href="slidestyle.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>Leaderboard</h1>

    <!-- Slider Container -->
    <div class="slider-container">
        <div class="slider">
            <!-- Slide 1: Daily Consume -->
            <div class="slide">
                <h2>Daily Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($dailyLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['count']; ?> cup<?php echo $entry['count'] !== 1 ? 's' : ''; ?>
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
                            <?php echo $entry['avg_daily']; ?> cup<?php echo $entry['avg_daily'] !== 1 ? 's' : ''; ?>
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
                            <?php echo $entry['total']; ?> cup<?php echo $entry['total'] !== 1 ? 's' : ''; ?>
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