<?php

namespace App\Middleware;

class SellerMiddleware {
	public function handle() {
		// If a user has not logged in or an error occurred
		if(!isset($_SESSION['user']) || !isset($_SESSION['user']['user_roles'])) {
			$this->preventNonSellerAccess();
			return;
		}
		// if the user logged in and their details were stored in the $_SESSION var
		if(!in_array('seller', $_SESSION['user']['user_roles'])) {
			$this->preventNonSellerAccess();
			return;
		}

		// if a user gets to this point, they are allowed because they are a seller
	}

	private function preventNonSellerAccess() {
		// set the flash_message
		$_SESSION['flash_message'] = 'Only sellers are allowed access to this page.<br />You need to request to become a seller and be approved by an admin.';

		// Get the referring URL
		$referrer = $_SERVER['HTTP_REFERER'] ?? '/pastimes/';
		// Redirect back to the referrer or to the login page if not available
		header('Location: ' . $referrer);

		exit();
	}
}
