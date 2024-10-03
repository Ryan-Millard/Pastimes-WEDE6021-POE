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
		background: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
		z-index: 1040; /* Below the popup */
		display: none; /* Hidden by default */
	}

	.flash_message-popup {
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 1050; /* Bootstrap modal z-index */
		border: 1px solid black;
		padding: 20px;
		border-radius: 5px;
		display: none; /* Hidden by default */
		background: white;
	}

	.flash_message-popup .flash_message-close-btn {
		background: transparent;
		border: none;
		cursor: pointer;
		float: left;
	}

	.flash_message-popup .flash_message-close-btn#xBtn {
		float: right;
	}
</style>

