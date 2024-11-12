<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class TransactionProductSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Transaction_Products';
		$this->tableStructure = '
			transaction_product_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			transaction_id INT(11) UNSIGNED NOT NULL,
			product_id INT(11) UNSIGNED NOT NULL,
			quantity TINYINT(3) UNSIGNED NOT NULL,
			PRIMARY KEY (transaction_product_id),
			INDEX (transaction_id),
			INDEX (product_id),
			CONSTRAINT fk_transaction_id FOREIGN KEY (transaction_id) REFERENCES Transactions(transaction_id),
			CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES Products(product_id)
		';
		$this->columnTypes = 'iiii';
		$this->seedFile = 'transactionProductsData.txt';
	}
}

