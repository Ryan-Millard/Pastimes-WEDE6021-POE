<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class ProductImageSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Product_Images';
		$this->tableStructure = '
			`product_image_id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
			`product_id` int(11) UNSIGNED NOT NULL,
			`product_image_url` varchar(255) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
			FOREIGN KEY (`product_id`) REFERENCES `Products`(`product_id`) ON DELETE CASCADE';
		$this->columnTypes = 'iisss';
		$this->seedFile = 'productImageData.txt';
	}
}
