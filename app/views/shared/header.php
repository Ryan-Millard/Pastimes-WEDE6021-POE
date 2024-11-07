<?php
	$userRoles = $_SESSION['user']['user_roles'];
?>

<nav class="navbar">
    <h2>Pastimes</h2>
    <div class="nav-links">
        <a href="/pastimes/" class="<?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/') ? 'active' : ''; ?>">Home</a>
        <a href="/pastimes/categories" class="<?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/categories') ? 'active' : ''; ?>">Shop</a>
        <a href="/pastimes/dashboard" class="<?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/dashboard') ? 'active' : ''; ?>">My Dashboard</a>
        <a href="/pastimes/admin" class="<?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/admin') ? 'active' : ''; ?>">Admin Panel</a>
    </div>
    <strong>
        <?php if(empty($_SESSION['user']['username'])): ?>
            <a class="light-emphasis <?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/login') ? 'active' : ''; ?>" href="/pastimes/login">Log in</a>
        <?php else: ?>
			<?php if(in_array('buyer', $userRoles)): ?>
				<a class="light-emphasis <?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/dashboard') ? 'active' : ''; ?>" href="/pastimes/dashboard#wishlist">Wishlist</a>
			<?php elseif(in_array('seller', $userRoles)): ?>
				<a class="light-emphasis <?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/dashboard') ? 'active' : ''; ?>" href="/pastimes/dashboard#soldItems">My Listings</a>
			<?php endif; ?>
            <a class="light-emphasis <?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/messages') ? 'active' : ''; ?>" href="/pastimes/messages">Messages</a>
            <a class="light-emphasis <?php echo ($_SERVER['REQUEST_URI'] == '/pastimes/logout') ? 'active' : ''; ?>" href="/pastimes/logout">Log out</a>
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

/* Active link styling with underline */
nav a.active {
	font-weight: bold;
    text-decoration: underline;
    text-underline-offset: 4px; /* Optional: add spacing between text and underline */
    text-decoration-thickness: 2px; /* Optional: increase thickness of underline */
    color: #007BFF; /* Optional: change color for active link */
}

/* Hover effect for active link (optional) */
nav a.active:hover {
    text-decoration: underline;
    text-underline-offset: 6px; /* Increase offset on hover */
    color: #0056b3; /* Slightly darker color on hover */
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
