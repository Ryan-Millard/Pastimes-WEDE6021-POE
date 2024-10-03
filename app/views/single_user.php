<h1>
	<?= htmlspecialchars($user['username']) ?>
</h1>


<table>
	<tr>
		<th>User ID</th>
		<td><?php echo htmlspecialchars($user['user_id']); ?></td>
	</tr>
	<tr>
		<th>Username</th>
		<td><?php echo htmlspecialchars($user['username']); ?></td>
	</tr>
	<tr>
		<th>Email</th>
		<td><?php echo htmlspecialchars($user['email']); ?></td>
	</tr>
	<tr>
		<th>First Name</th>
		<td><?php echo htmlspecialchars($user['first_name']); ?></td>
	</tr>
	<tr>
		<th>Last Name</th>
		<td><?php echo htmlspecialchars($user['last_name']); ?></td>
	</tr>
	<tr>
		<th>Bio</th>
		<td><?php echo $user['bio'] ? htmlspecialchars($user['bio']) : 'N/A'; ?></td>
	</tr>
	<tr>
		<th>Phone Number</th>
	<td><?php echo $user['phone_number'] ? htmlspecialchars($user['phone_number']) : 'N/A'; ?></td>
	</tr>
</table>

<!-- Form to Approve User -->
<form action="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>" method="post">
	<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

	<label for="role">Select Role:</label>
	<select name="role" id="role" required>
		<option value="">--Select Role--</option>
		<option value="buyer">Buyer</option>
		<option value="seller">Seller</option>
		<option value="admin">Admin</option>
	</select>

	<button type="submit" name="approve" value="1">Approve User</button>
</form>

<!-- Form to Reject User -->
<form action="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>" method="post">
	<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
	<button type="submit" name="approve" value="0">Reject User</button>
</form>
