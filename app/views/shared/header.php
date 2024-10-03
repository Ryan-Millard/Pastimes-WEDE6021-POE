<nav class="navbar">
	<h2>Pastimes</h2>
	<a href="/pastimes/">Home</a>
	<a href="/pastimes/categories">Categories</a>
	<a href="/pastimes/dashboard">My Dashboard</a>
	<a href="/pastimes/admin">Admin Panel</a>
	<?php if(empty($_SESSION['user']['username'])): ?>
		<a href="/pastimes/login">Log in</a>
	<?php else: ?>
		Logged in as: <?= $_SESSION['user']['username'] ?>
		<a href="/pastimes/logout">Log out</a>
	<?php endif; ?>
</nav>
