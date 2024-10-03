<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class UserSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Users';
		$this->tableStructure = '
			user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
			username VARCHAR(255) UNIQUE NOT NULL,
			email VARCHAR(255) NOT NULL,
			password_hash VARCHAR(255) NOT NULL,
			first_name VARCHAR(100) NOT NULL,
			last_name VARCHAR(100) NOT NULL,
			bio TEXT,
			phone_number VARCHAR(15),
			registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			last_login DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP';
		$this->columnTypes = 'isssssssss';
		$this->seedFile = 'userData.txt';
	}

	protected function loadData(?callable $callback = null) {
		// Define the hashPassword function to modify the password
		$hashPassword = function(&$data) {
			if(empty($data[3])) {
				throw new \Exception("Password cannot be empty for user.");
			}
			$data[3] = password_hash($data[3], PASSWORD_DEFAULT);
			return $data; // Return the modified data
		};

		// Pass the hashPassword function as a callback
		parent::loadData($hashPassword);
	}
}

