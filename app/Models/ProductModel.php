<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class ProductModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Products';
		$this->tablePrimaryKey = 'product_id';
	}

	public function getAllPending() {
		return $this->getAllByColumnValue('product_status', 'pending');
	}
}
