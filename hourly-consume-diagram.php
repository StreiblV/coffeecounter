<?php
// Generate time labels from 00:00 to the current time (e.g., 08:07)
$currentTime = new DateTime();
$startTime = new DateTime('00:00');
$interval = new DateInterval('PT1M'); // 1-minute intervals
$timePeriod = new DatePeriod($startTime, $interval, $currentTime->add($interval)); // Add interval to include the current minute

$timeLabels = [];
foreach ($timePeriod as $time) {
    $timeLabels[] = $time->format('H:i'); // Generate labels like 00:00, 00:01, ..., 08:07
}

// Initialize data array for all labels with 0 counts
$chartData = array_fill_keys($timeLabels, 0);

// Populate the chart data from database entries
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

    foreach ($entries as $entry) {
        $chartData[$entry['time']] = (int)$entry['count'];
    }
}
?>

<h1>Your Caffeine Consumption Today</h1>
<div class="chart-container">
    <canvas id="dailyChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('dailyChart').getContext('2d');

        // Data from PHP
        const labels = <?php echo json_encode(array_keys($chartData)); ?>; // Time labels from 00:00 to current time
        const data = <?php echo json_encode(array_values($chartData)); ?>; // Corresponding data points

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Energy Levels Added',
                    data: data,
                    borderColor: '#795548',
                    backgroundColor: 'rgba(121, 85, 72, 0.5)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time (HH:mm)'
                        },
                        ticks: {
                            autoSkip: true, // Skip labels for readability if too crowded
                            maxTicksLimit: 10 // Adjust this to control the number of visible ticks
                        },
                        min: '<?php echo reset($timeLabels); ?>', // First label (00:00)
                        max: '<?php echo end($timeLabels); ?>',  // Last label
                        type: 'category' // Use category scale for exact label placement
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Boosts'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>