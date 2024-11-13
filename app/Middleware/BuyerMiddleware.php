<?php

namespace App\Middleware;

class BuyerMiddleware {
	public function handle() {
		// If a user has not logged in or an error occurred
		if(!isset($_SESSION['user']) || !isset($_SESSION['user']['user_roles'])) {
			$this->preventNonBuyerAccess();
			return;
		}
		// If the user logged in and their details were stored in the $_SESSION var
		if(!in_array('buyer', $_SESSION['user']['user_roles'])) {
			$this->preventNonBuyerAccess();
			return;
		}

		// If a user gets to this point, they are allowed because they are a buyer
	}

	private function preventNonBuyerAccess() {
		// Set the flash message
		$_SESSION['flash_message'] = 'Only buyers are allowed access to this page.<br />You need to sign up as a buyer to gain access.';

		// Get the referring URL
		$referrer = $_SERVER['HTTP_REFERER'] ?? '/pastimes/';
		// Redirect back to the referrer or to the login page if not available
		header('Location: ' . $referrer);

		exit();
	}
}
