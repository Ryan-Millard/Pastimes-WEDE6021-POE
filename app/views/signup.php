<h2>Sign Up</h2>
<p>
	Already have an account? 
	<a href="/pastimes/login">Log in</a>
</p>

<?php if(isset($error)): ?>
	<p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="/pastimes/signup" method="POST" enctype="multipart/form-data">
	<label for="username">Username:</label>
	<input
		type="text"
		name="username"
		value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
		required
	><br>

	<label for="password">Password:</label>
	<input
		type="password"
		name="password"
		value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
		required
	><br>

	<label for="email">Email:</label>
	<input
		type="email"
		name="email"
		value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
		required
	><br>

	<label for="first_name">First Name:</label>
	<input
		type="text"
		name="first_name"
		value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
		required
	><br>

	<label for="last_name">Last Name:</label>
	<input
		type="text"
		name="last_name"
		value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
		required
	><br>

	<label for="bio">Bio:</label>
	<textarea
		name="bio"
		value="<?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?>"
	>
	</textarea><br>

	<label for="phone_number">Phone Number:</label>
	<input
		type="tel"
		name="phone_number"
		maxlength="15"
		value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>"
	><br>

	<button type="submit">Sign Up</button>
</form>

