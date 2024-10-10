<?php
// Check if a flash message is required
$message = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : '';

// Clear the flash message after displaying
unset($_SESSION['flash_message']);
?>

<!-- Popup HTML Structure -->
<div class="flash_message-overlay" id="flash_messageOverlay" style="display: none;"></div>
<div class="flash_message-popup" id="flash_messagePopup" style="display: none;">
	<button id="xBtn" class="flash_message-close-btn" onclick="close_flash_messagePopup()">&times;</button>
	<h5>Notice</h5>
	<p id="flash_messagePopupMsg"><?php echo htmlspecialchars($message); ?></p>
	<div class="flash_message-close-btn">
		<a onclick="close_flash_messagePopup()">Ok</a>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Check if there is a message to show
		const message = "<?php echo addslashes($message); ?>"; // Safely pass the PHP variable
		if (message) {
			showPopup(message);
		}
	});

	function showPopup(message) {
		const popup = document.getElementById('flash_messagePopup');
		const overlay = document.getElementById('flash_messageOverlay');
		const messageText = document.getElementById('flash_messagePopupMsg');
		messageText.innerHTML = message; // Set the message
		popup.style.display = 'block'; // Show the popup
		overlay.style.display = 'block'; // Show the overlay
	}

	function close_flash_messagePopup() {
		const popup = document.getElementById('flash_messagePopup');
		const overlay = document.getElementById('flash_messageOverlay');
		popup.style.display = 'none'; // Hide the popup
		overlay.style.display = 'none'; // Hide the overlay
	}
</script>

<style>
/* Custom Popup Styles */
.flash_message-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Darker semi-transparent black for better visibility */
    z-index: 1040; /* Below the popup */
    display: none; /* Hidden by default */
    transition: opacity 0.3s ease; /* Smooth transition for overlay */
}

.flash_message-popup {
    position: fixed;
    top: 50%;
    left: 50%;
	min-width: 30%;
    transform: translate(-50%, -50%);
    z-index: 1050; /* Above the overlay */
    border: 1px solid #ccc; /* Light gray border for better separation */
    border-radius: 8px; /* Rounded corners */
    padding: 20px;
    background: #ffffff; /* White background for contrast */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
    display: none; /* Hidden by default */
    animation: popupFadeIn 0.4s ease; /* Animation for showing the popup */
}

/* Close button styles */
.flash_message-popup .flash_message-close-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    color: #555; /* Slightly darker gray for text */
    font-size: 20px;
    transition: color 0.3s ease; /* Smooth color transition */
}

.flash_message-popup .flash_message-close-btn:hover {
    color: #007BFF; /* Change color on hover */
}

.flash_message-popup h5 {
    font-size: 1.2rem; /* Slightly larger heading */
    margin-bottom: 10px; /* Space below heading */
    color: #333; /* Darker color for better readability */
}

.flash_message-popup p {
    font-size: 1rem; /* Standard font size */
    color: #666; /* Lighter gray for message text */
}

/* Ok button styles */
.flash_message-popup .flash_message-close-btn a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 15px; /* Padding for the button */
    background-color: #007BFF; /* Blue background */
    color: white; /* White text color */
    text-decoration: none; /* No underline */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s ease; /* Smooth background transition */
}

.flash_message-popup .flash_message-close-btn a:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

/* Animation for popup */
@keyframes popupFadeIn {
    0% {
        opacity: 0; /* Start invisible */
        transform: translate(-50%, -40%); /* Slightly higher */
    }
    100% {
        opacity: 1; /* Fully visible */
        transform: translate(-50%, -50%); /* Centered */
    }
}

</style>
