<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Model;
use App\Controllers\Controller;

class Error404Controller extends Controller {
	public function __construct(Model $model = null) {
		parent::__construct($model);
	}

	public function show404() {
		$this->render('404');
	}
}

