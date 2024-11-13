<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class AdminModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Admins';
	}

	public function getByUserId($userId) {
		return $this->getByColumnValue('user_id', $userId);
	}
}
