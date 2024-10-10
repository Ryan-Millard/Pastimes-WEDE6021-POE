<nav class="navbar">
	<h2>Pastimes</h2>
	<a href="/pastimes/">Home</a>
	<a href="/pastimes/categories">Categories</a>
	<a href="/pastimes/dashboard">My Dashboard</a>
	<a href="/pastimes/admin">Admin Panel</a>
	<strong>
		<?php if(empty($_SESSION['user']['username'])): ?>
			<a class="light-emphasis" href="/pastimes/login">Log in</a>
		<?php else: ?>
				<span class="emphasis">
					Logged in as: <?= $_SESSION['user']['username'] ?>
				</span>
			<a class="light-emphasis" href="/pastimes/logout">Log out</a>
		<?php endif; ?>
	</strong>
</nav>

<style>

nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

nav a {
    color: #333;
    text-decoration: none;
    padding: 10px 20px;
    transition: color 0.3s;
}

nav a:hover {
    color: #007BFF;
}

header {
    background-color: #ffffff;
    padding: 10px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}
/* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f8f8f8;
    color: #333;
    font-size: 16px;
    line-height: 1.6;
}

main {
	padding: 2%;
}

.emphasis {
	color: #007BFF;
}
.light-emphasis {
	color: #777777;
}

</style>
