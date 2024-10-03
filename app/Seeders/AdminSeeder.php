<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class AdminSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Admins';
		$this->tableStructure = '
			`admin_id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			`user_id` int(11) UNSIGNED NOT NULL,
			`role` varchar(100) NOT NULL DEFAULT \'Admin\',
			FOREIGN KEY (`user_id`) REFERENCES Users(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE';
		$this->columnTypes = 'iis';
		$this->seedFile = 'adminData.txt';
	}
}
