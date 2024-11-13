<?php

namespace App\Middleware;

require_once __DIR__ . './../models/AdminModel.php';
require_once __DIR__ . './../models/UserModel.php';

use App\Models\AdminModel;
use App\Models\UserModel;

class AdminMiddleware {
	public function handle(AdminModel $adminModel) {
		if(isset($_SESSION['admin']))
			return;

		$user_id = $_SESSION['user']['user_id'];
		$adminDetails = $adminModel->getByColumnValue('user_id', $user_id);

		// If the query returned the admin entry with the FK to user_id
		if(!empty($adminDetails)) {
			$_SESSION['admin'] = $adminDetails;
			return;
		}

		// set the flash_message
		$_SESSION['flash_message'] = 'Only admins are allowed access to this page.';

		// Get the referring URL
		$referrer = $_SERVER['HTTP_REFERER'] ?? '/pastimes';
		// Redirect back to the referrer or to the login page if not available
		header('Location: ' . $referrer);

		exit();
	}
}
