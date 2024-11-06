<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class MessageSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Messages';
		$this->tableStructure = '
			message_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
			sender_id INT UNSIGNED NOT NULL,
			receiver_id INT UNSIGNED NOT NULL,
			message TEXT NOT NULL,
			sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			seen BOOLEAN DEFAULT FALSE NOT NULL,
			seen_at TIMESTAMP NULL,
			FOREIGN KEY (sender_id) REFERENCES Users(user_id),
			FOREIGN KEY (receiver_id) REFERENCES Users(user_id)
		';
		$this->columnTypes = 'iiissis';
		$this->seedFile = 'messageData.txt';
	}
}
