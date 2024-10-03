<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class SellerModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Sellers';
	}
}

