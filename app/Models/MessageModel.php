<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

public class MessageModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Messages';
	}
}
