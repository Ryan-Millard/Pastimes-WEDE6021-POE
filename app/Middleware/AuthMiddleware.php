<?php

namespace App\Middleware;

class AuthMiddleware {
	public function handle() {
		if(isset($_SESSION['user']['username']) && isset($_SESSION['user']['password_hash']))
			return;

		// set the flash_message
		$_SESSION['flash_message'] = 'You need to be logged in to view that page. ';

		// Redirect back to the referrer or to the login page if not available
		header('Location: ' . '/pastimes/login');

		exit();
	}
}
