<?php

namespace App\Middleware;

class AuthMiddleware {
	public function handle() {
		if(isset($_SESSION['user']['username']) && isset($_SESSION['password_hash']))
			return;

		// set the flash_message
		$_SESSION['flash_message'] = 'You need to be logged in to view that page.';

		// Get the referring URL
		$referrer = $_SERVER['HTTP_REFERER'] ?? '/pastimes/login';
		// Redirect back to the referrer or to the login page if not available
		header('Location: ' . $referrer);

		exit();
	}
}
