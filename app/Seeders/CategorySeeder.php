<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class CategorySeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Categories';
		$this->tableStructure = '
			`category_id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			`category_name` varchar(25) NOT NULL UNIQUE,
			`description` text DEFAULT NULL';
		$this->columnTypes = 'iss';
		$this->seedFile = 'categoryData.txt';
	}
}
