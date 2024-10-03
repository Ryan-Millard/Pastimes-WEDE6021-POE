<h2>Login</h2>
<p>
	Don't have an account? 
	<a href="/pastimes/signup">Sign up</a>
</p>

<?php if(isset($error)): ?>
	<p style="color:red;"><?= $error; ?></p>
<?php endif; ?>

<form action="/pastimes/login" method="POST">
	<label for="username">Username:</label>
	<input
		type="text"
		name="username"
		value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
		required
	><br>

	<label for="password">Password:</label>
	<input
		type="password"
		name="password"
		value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
		required
	><br>

	<button type="submit">Login</button>
</form>

