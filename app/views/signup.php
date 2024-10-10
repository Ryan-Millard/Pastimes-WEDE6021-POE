<div class="sign-up-container">
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
        >

        <label for="password">Password:</label>
        <input
            type="password"
            name="password"
            value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
            required
        >

        <label for="email">Email:</label>
        <input
            type="email"
            name="email"
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
            required
        >

        <label for="first_name">First Name:</label>
        <input
            type="text"
            name="first_name"
            value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
            required
        >

        <label for="last_name">Last Name:</label>
        <input
            type="text"
            name="last_name"
            value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
            required
        >

        <label for="bio">Bio:</label>
        <textarea
            name="bio"
        ><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?></textarea>

        <label for="phone_number">Phone Number:</label>
        <input
            type="tel"
            name="phone_number"
            maxlength="15"
            value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>"
        >

        <button type="submit">Sign Up</button>
    </form>
</div>


<style>
/* Style for the sign-up container */
.sign-up-container {
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

/* Style for all form elements */
.sign-up-container label {
    margin-top: 10px; /* Space above each label */
}

.sign-up-container input,
.sign-up-container textarea {
    width: 100%; /* Full width for inputs */
    padding: 10px; /* Add padding for inputs */
    margin-bottom: 15px; /* Space below each input */
    border: 1px solid #ccc; /* Light border for inputs */
    border-radius: 4px; /* Rounded corners for inputs */
}

/* Style for the button */
.sign-up-container button {
    padding: 10px 20px; /* Add padding for the button */
    background-color: #007bff; /* Bootstrap primary color for button */
    color: white; /* White text color */
    border: none; /* Remove default border */
    border-radius: 4px; /* Rounded corners for button */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth transition for hover */
}

/* Button hover effect */
.sign-up-container button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

/* Error message styling */
.sign-up-container p[style="color:red;"] {
    margin-top: 10px; /* Space above the error message */
    font-weight: bold; /* Make the error message bold */
}

</style>
