<h1>Admin Panel</h1>

<h3>Users Pending Approval:</h3>
<ul>
	<?php if(!empty($users)): ?>
		<?php foreach($users as $user): ?>
			<li>
			<a href="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>">
					<?php echo htmlspecialchars($user['username']); ?> - 
				</a>
				<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
			</li>
		<?php endforeach; ?>
	<?php else: ?>
		<li>No users found.</li>
	<?php endif; ?>
</ul>
