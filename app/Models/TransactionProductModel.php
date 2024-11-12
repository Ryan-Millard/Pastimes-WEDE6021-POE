<?php

namespace App\Models;

use App\Models\Model;

class TransactionProductModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Transaction_Products';
		$this->tablePrimaryKey = 'transaction_product_id';
	}

	public function getAllByTransactionId($transactionId) {
		return $this->getAllByColumnValue('transaction_id', $transactionId);
	}
}
