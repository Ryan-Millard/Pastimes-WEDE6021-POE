<h1 class="admin-title">Admin Panel</h1>

<div class="box admin-dashboard-container">
	<div class="pending-users">
		<h3 class="pending-title">Users Pending Approval:</h3>
		<div class="container">
			<ul class="user-list">
				<?php if(!empty($users)): ?>
					<?php foreach($users as $user): ?>
						<a class="user-link" href="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>">
							<li class="user-item">
								<span class="user-username"><?php echo htmlspecialchars($user['username']); ?> - </span>
								<span class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
							</li>
						</a>
					<?php endforeach; ?>
				<?php else: ?>
					<li class="no-users">No users found.</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="box pending-products">
		<h3 class="pending-title">Products Pending Approval:</h3>
		<?php require 'product_list.php'; ?>
	</div>
</div>
<style>
/* Admin Panel Title */
.admin-title {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

/* Pending Users Title */
.pending-title {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #555;
}

/* User List */
.user-list {
    list-style-type: none;
    padding: 0;
	text-align: center;
}

/* Individual User Item */
.user-item {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}
.user-item:hover {
    background-color: white;
	font-weight: bold;
}

/* User Link */
.user-link {
    color: #555555;
    text-decoration: none;
}

.user-username {
	color: #007bff;
}

/* User Name */
.user-name {
    color: #555;
}

/* No Users Message */
.no-users {
    font-style: italic;
    color: #777;
    text-align: center;
    padding: 20px;
}

.admin-dashboard-container {
	display: flex;
}
.box {
	padding: 10px;
	box-sizing: border-box;
}
.pending-users {
	padding: 10px;
	box-sizing: border-box;
	width: 100%;
}
.pending-products {
	width: 100%;
}
</style>
