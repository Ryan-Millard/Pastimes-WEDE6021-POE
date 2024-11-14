<?php

namespace App\Seeders;

require_once __DIR__ . '/../Database/DBConn.php';
use App\Database\Database;

require_once __DIR__ . '/UserSeeder.php';
require_once __DIR__ . '/AdminSeeder.php';
require_once __DIR__ . '/BuyerSeeder.php';
require_once __DIR__ . '/SellerSeeder.php';
require_once __DIR__ . '/CategorySeeder.php';
require_once __DIR__ . '/ProductSeeder.php';
require_once __DIR__ . '/ProductImageSeeder.php';
require_once __DIR__ . '/WishlistSeeder.php';
require_once __DIR__ . '/MessageSeeder.php';
require_once __DIR__ . '/TransactionSeeder.php';
require_once __DIR__ . '/TransactionProductSeeder.php';

use App\Seeders\UserSeeder;
use App\Seeders\AdminSeeder;
use App\Seeders\BuyerSeeder;
use App\Seeders\SellerSeeder;
use App\Seeders\CategorySeeder;
use App\Seeders\ProductSeeder;
use App\Seeders\ProductImageSeeder;
use App\Seeders\WishlistSeeder;
use App\Seeders\MessageSeeder;
use App\Seeders\TransactionSeeder;
use App\Seeders\TransactionProductSeeder;

class SeedDatabase {
	public static function seed() {
		try {
			// Initialize the connection (won't create the database or load the dump)
			Database::init();
			// Create the database and load the SQL dump (only when you need to)
			if(Database::createDatabaseIfNotExists())
				return;

			// Instantiate the UserSeeder class
			$userSeeder = new UserSeeder();
			$adminSeeder = new AdminSeeder();
			$buyerSeeder = new BuyerSeeder();
			$sellerSeeder = new SellerSeeder();
			$categorySeeder = new CategorySeeder();
			$productSeeder = new ProductSeeder();
			$productImageSeeder = new ProductImageSeeder();
			$wishlistSeeder = new WishlistSeeder();
			$messageSeeder = new MessageSeeder();
			$transactionSeeder = new TransactionSeeder();
			$transactionProductSeeder= new TransactionProductSeeder();

			// Execute the seed method for each table
			// NB the order due to FKs
			$userSeeder->seed();
			$adminSeeder->seed();
			$buyerSeeder->seed();
			$sellerSeeder->seed();

			$categorySeeder->seed();

			$productSeeder->seed();
			$productImageSeeder->seed();

			$wishlistSeeder->seed();

			$messageSeeder->seed();

			$transactionSeeder->seed();
			$transactionProductSeeder->seed();

			echo "Seeding completed successfully!\n";
		} catch(\Exception $e) {
			// Catch and display any errors that occur during seeding
			echo "Seeding failed: " . $e->getMessage() . "\n";
		}
	}
}

