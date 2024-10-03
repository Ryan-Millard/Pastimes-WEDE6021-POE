<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class SellerSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Sellers';
		$this->tableStructure = '
			`seller_id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			`user_id` int(11) UNSIGNED NOT NULL,
			`seller_rating` float DEFAULT NULL,
			`total_sales` int(11) UNSIGNED NOT NULL DEFAULT 0,
			FOREIGN KEY (`user_id`) REFERENCES Users(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE';
		$this->columnTypes = 'iids';
		$this->seedFile = 'sellerData.txt';
	}
}


