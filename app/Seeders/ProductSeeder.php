<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class ProductSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Products';
		$this->tableStructure = '
			`product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`seller_id` int(11) UNSIGNED NOT NULL,
			`category_id` int(11) UNSIGNED NOT NULL,
			`product_condition` enum(\'new\', \'used\', \'refurbished\') NOT NULL,
			`product_status` enum(\'pending\', \'approved\', \'rejected\') NOT NULL,
			`product_name` varchar(255) NOT NULL,
			`description` text DEFAULT NULL,
			`price` decimal(10,2) NOT NULL,
			`quantity_available` int(11) UNSIGNED NOT NULL DEFAULT 0,
			`size` varchar(50) DEFAULT NULL,
			`color` varchar(50) DEFAULT NULL,
			`brand` varchar(100) DEFAULT NULL,
			`material` varchar(100) DEFAULT NULL,
			`tags` text DEFAULT NULL,
			`date_listed` datetime NOT NULL DEFAULT current_timestamp(),
				FOREIGN KEY (`seller_id`) REFERENCES `Sellers` (`seller_id`),
				FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`)';
		$this->columnTypes = 'iiissssdissssss';
		$this->seedFile = 'productData.txt';
	}
}





