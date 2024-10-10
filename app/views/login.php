<div class="login-container">
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
</div>


<style>
/* Login Container */
/* Style for the login container */
.login-container {
    display: flex; /* Use flexbox */
    flex-direction: column; /* Stack items vertically */
    align-items: center; /* Center items horizontally (optional) */
    justify-content: center; /* Center items vertically (optional) */
    padding: 20px; /* Add some padding around the container */
    background-color: #f8f9fa; /* Light background for visibility */
    border: 1px solid #ddd; /* Light border for separation */
    border-radius: 5px; /* Rounded corners */
    max-width: 400px; /* Set a max width for the container */
    margin: auto; /* Center the container horizontally */
}

/* Form Styles */
.login-container form {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

/* Header Styling */
.login-container h2 {
    color: #333333;
    font-size: 24px;
    text-align: center;
    margin-bottom: 10px;
}

/* Link Styling */
.login-container p {
    color: #555555;
    text-align: center;
}

.login-container a {
    color: #0066cc;
    text-decoration: none;
    font-weight: bold;
}

.login-container a:hover {
    color: #004499;
    text-decoration: underline;
}

/* Error Message */
.login-container p[style*="color:red"] {
    color: #e74c3c;
    font-weight: bold;
    text-align: center;
}

/* Form Label Styling */
.login-container label {
    display: block;
    font-size: 14px;
    color: #555555;
    margin-top: 15px;
}

/* Input Fields */
.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #dddddd;
    border-radius: 4px;
    font-size: 14px;
    margin-top: 5px;
    box-sizing: border-box;
}

.login-container input[type="text"]:focus,
.login-container input[type="password"]:focus {
    border-color: #0066cc;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 102, 204, 0.3);
}

/* Submit Button */
.login-container button[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background-color: #0066cc;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-container button[type="submit"]:hover {
    background-color: #004499;
}

</style>
