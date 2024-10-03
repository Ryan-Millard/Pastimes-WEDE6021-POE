<?php

namespace App\Controllers;

require_once __DIR__ . './../models/UserModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\UserModel;
use App\Controllers\Controller;

class DashboardController extends Controller {
	public function __construct(UserModel $model = null) {
		parent::__construct($model);
	}

	public function showDashboard() {
		$this->render('userDashboard');
	}
}
