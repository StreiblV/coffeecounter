<?php
session_start();

// Redirect logged-in users directly to the coffee tracker
if (isset($_SESSION['username'])) {
    header("Location: coffee-tracker.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<body>
    <!-- Landing Page -->
    <header>
        <h1>Welcome to Coffee Counter</h1>
        <p>Track your coffee consumption like a pro!</p>
    </header>
    <main>
        <p>
            Ever wondered how much coffee you drink every day? <br>
            Use our Coffee Counter to track your caffeine habits, and take control of your daily coffee intake.
        </p>
        <div class="button-group">
            <a id="btn-primary" href="login.php" class="btn">Login</a>
            <a id="btn-secondary" href="register.php" class="btn">Register</a>
        </div>
    </main>
</body>
</html>