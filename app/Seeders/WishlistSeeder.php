<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class WishlistSeeder extends Seeder {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Wishlist';
		$this->tableStructure = '
			`wishlist_item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`buyer_id` int(11) UNSIGNED NOT NULL,
			`product_id` int(11) UNSIGNED NOT NULL,
			`quantity` int(11) UNSIGNED NOT NULL,
			PRIMARY KEY (`wishlist_item_id`),
			UNIQUE KEY `unique_wishlist_item` (`buyer_id`, `product_id`),
			KEY `product_id` (`product_id`),
			CONSTRAINT `Wishlist_ibfk_1`
				FOREIGN KEY (`buyer_id`)
				REFERENCES `Buyers` (`buyer_id`)
				ON DELETE CASCADE ON UPDATE CASCADE,
			CONSTRAINT `Wishlist_ibfk_2`
				FOREIGN KEY (`product_id`)
				REFERENCES `Products` (`product_id`)
				ON DELETE CASCADE ON UPDATE CASCADE
		';
		$this->columnTypes = 'iiii';
		$this->seedFile = 'wishlistData.txt';
	}
}

