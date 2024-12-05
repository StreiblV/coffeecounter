<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="css/slidestyle.css">
    <style>
        .slider-container {
            overflow: hidden;
            position: relative;
            max-width: 800px;
            margin: auto;
        }
        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
        }
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #795548;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .slider-btn.left {
            left: 10px;
        }
        .slider-btn.right {
            right: 10px;
        }
        .leaderboard-list li {
            list-style: none;
            padding: 10px;
            margin: 5px 0;
            background: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>Leaderboard</h1>
	<h2>Today's Top Consumer</h2>
    <p>Coffee: <b><?php echo htmlspecialchars($top_coffee); ?></b></p>
    <p>Wildkraut: <b><?php echo htmlspecialchars($top_wildkraut); ?></b></p>
    <p>Energydrink: <b><?php echo htmlspecialchars($top_energydrink); ?></b></p>
    <p>Coke: <b><?php echo htmlspecialchars($top_coke); ?></b></p>

    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <h2>Daily Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($dailyLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['total_points']; ?> Energy Levels
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="slide">
                <h2>Average Daily Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($averageLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['avg_daily']; ?> Energy Levels
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="slide">
                <h2>Total Consume</h2>
                <ul class="leaderboard-list">
                    <?php foreach ($totalLeaderboard as $entry): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                            <?php echo $entry['total_points']; ?> Energy Levels
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button class="slider-btn left">&larr;</button>
        <button class="slider-btn right">&rarr;</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.querySelector('.slider');
            const slides = document.querySelectorAll('.slide');
            const leftButton = document.querySelector('.slider-btn.left');
            const rightButton = document.querySelector('.slider-btn.right');
            let currentSlide = 0;

            function updateSlider() {
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            }

            leftButton.addEventListener('click', () => {
                currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
                updateSlider();
            });

            rightButton.addEventListener('click', () => {
                currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
                updateSlider();
            });
        });
    </script>
</body>
</html>