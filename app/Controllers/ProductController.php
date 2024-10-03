<?php

namespace App\Controllers;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . './../models/ProductModel.php';

use App\Models\UserModel;
use App\Controllers\Controller;

class ProductController extends Controller {
	public function __construct($model = null) {
		parent::__construct($model);
	}
}

