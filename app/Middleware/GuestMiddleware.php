<?php

namespace App\Middleware;

class GuestMiddleware {
	public function handle() {
		// Check if the user is not logged in by checking the session
		if (!isset($_SESSION['user']['username'])) {
			return; // User is not logged in, allow the request
		}

		// Get the previous URL from the HTTP referer or default to home page
		$previousUrl = $_SERVER['HTTP_REFERER'] ?? '/pastimes';
		$parsedUrl = parse_url($previousUrl);

		// Prevent open redirect attacks by checking if referer is from the same domain
		if (isset($parsedUrl['host']) && $parsedUrl['host'] !== $_SERVER['SERVER_NAME']) {
			$previousUrl = '/pastimes';
		}

		$_SESSION['flash_message'] = 'Only users who are not logged in can access that page';

		// Redirect the user back to the previous page or a safe page
		header("Location: " . $previousUrl);
		exit();
	}
}

