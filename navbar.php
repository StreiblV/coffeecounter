<script>
	function toggleMenu() {
		const navbarMenu = document.querySelector('.navbar-menu');
		navbarMenu.classList.toggle('active');
	}
</script>
<nav class="navbar">
	<div class="logo">Caffinity</div>
	<div class="menu-icon" onclick="toggleMenu()">
		☰
	</div>
	<ul class="navbar-menu">
		<li><a href="coffee-tracker.php">Caffein Time</a></li>
		<li><a href="analytics.php">Analytics</a></li>
		<li><a href="leaderboard.php">Leaderboard</a></li>
		<li><a href="socialmedia.php">Social Media</a></li>
		<li><a href="user.php">User</a></li>
	</ul>
</nav>
