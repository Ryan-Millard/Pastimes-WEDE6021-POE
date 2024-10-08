<?php

namespace App\Seeders;

require_once __DIR__ . '/UserSeeder.php';
require_once __DIR__ . '/AdminSeeder.php';
require_once __DIR__ . '/BuyerSeeder.php';
require_once __DIR__ . '/SellerSeeder.php';
require_once __DIR__ . '/CategorySeeder.php';
require_once __DIR__ . '/ProductSeeder.php';
require_once __DIR__ . '/ProductImageSeeder.php';

use App\Seeders\UserSeeder;
use App\Seeders\AdminSeeder;
use App\Seeders\BuyerSeeder;
use App\Seeders\SellerSeeder;
use App\Seeders\CategorySeeder;
use App\Seeders\ProductSeeder;
use App\Seeders\ProductImageSeeder;

class SeedDatabase {
	public static function seed() {
		try {
			// Instantiate the UserSeeder class
			$userSeeder = new UserSeeder();
			$adminSeeder = new AdminSeeder();
			$buyerSeeder = new BuyerSeeder();
			$sellerSeeder = new SellerSeeder();
			$categorySeeder = new CategorySeeder();
			$productSeeder = new ProductSeeder();
			$productImageSeeder = new ProductImageSeeder();

			// Execute the seed method for each table
			$userSeeder->seed();
			$adminSeeder->seed();
			$buyerSeeder->seed();
			$sellerSeeder->seed();
			$categorySeeder->seed();
			$productSeeder->seed();
			$productImageSeeder->seed();

			echo "Seeding completed successfully!\n";
		} catch(\Exception $e) {
			// Catch and display any errors that occur during seeding
			echo "Seeding failed: " . $e->getMessage() . "\n";
		}
	}
}

