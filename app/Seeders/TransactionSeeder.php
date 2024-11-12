<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class TransactionSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Transactions';
		$this->tableStructure = '
			transaction_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			buyer_id INT(11) UNSIGNED NOT NULL,
			transaction_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
			total_price DECIMAL(10,2) NOT NULL,
			shipping_address TEXT COLLATE utf8mb4_general_ci NOT NULL,
			payment_method ENUM(\'Credit Card\', \'Debit Card\', \'PayPal\', \'Bank Transfer\') COLLATE utf8mb4_general_ci NOT NULL,
			reference_number VARCHAR(50) NOT NULL UNIQUE,
			PRIMARY KEY (transaction_id),
			INDEX (buyer_id),
			CONSTRAINT fk_buyer_id FOREIGN KEY (buyer_id) REFERENCES `Buyers`(buyer_id)
		';
		$this->columnTypes = 'iisdsss';
		$this->seedFile = 'transactionsData.txt';
	}

	// Function to generate the reference number
	protected function generateReferenceNumber($transaction_id) {
		// Generate a mock session ID
		$mock_session_id = bin2hex(random_bytes(16)); // Generates a 32-character session-like ID

		return 'REF-' . date('Y') . '-' . str_pad($transaction_id, 6, '0', STR_PAD_LEFT) . '-' . $mock_session_id;
	}

	protected function loadData(?callable $callback = null) {
		//	use callback to generate ref no
		parent::loadData(function(&$data) {
			if(empty($data[0])) {
				throw new \Exception("Transaction ID cannot be empty when generating ref number.");
			}
			$data[6] = $this->generateReferenceNumber($data[0]);
			return $data;	// return modified data
		});
	}
}
