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
<form action="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>" method="post" class="approve-form">
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
	<button class="reject-user" type="submit" name="approve" value="0">Reject User</button>
</form>


<style>
/* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 20px;
}

/* Header styles */
h1 {
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

/* Table styles */
table {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    border-collapse: collapse;
    background: white;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #5BC0DE;
    color: white;
}

/* Row hover effect */
tr:hover {
    background-color: #f1f1f1;
}

/* Form styles */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
}

select {
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    max-width: 300px;
}

button {
    padding: 10px 20px;
    color: white;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

.reject-user {
	background-color: #ff4757;
}


</style>
