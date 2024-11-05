<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';
require_once __DIR__ . './../models/ProductImageModel.php';
require_once __DIR__ . './../models/ProductModel.php';

use App\Models\Model;
use App\Models\ProductModel;
use App\Models\ProductImageModel;

class WishlistModel extends Model {
	protected $productImageModel;
	protected $productModel;

	public function __construct(ProductImageModel $productImageModel = null, ProductModel $productModel = null) {
		parent::__construct();
		$this->tableName = 'Wishlist';

		$this->productImageModel = $productImageModel;
		$this->productModel = $productModel;
	}

	// Override the insert method
	public function insert($data) {
		foreach($data as $key => $value)
		// Ensure that the buyer_id and product_id are provided
		if (!isset($data['buyer_id']) || !isset($data['product_id']) || !isset($data['quantity'])) {
			throw new \Exception("Buyer ID, Product ID and quantity must be provided.");
		}

		// Check if the entry already exists
		$existingEntry =
			$this->getAllByColumnValue('buyer_id', $data['buyer_id']);	// fetch all of buyer's entries
		foreach($existingEntry as $key => $entry) {
			// If one exists for buyer and product, exit and leave $existingEntry truthy
			if($entry['buyer_id'] === $data['buyer_id'] && $entry['product_id'] === $data['product_id'])
				break;

			unset($existingEntry[$key]); // Remove the entry if no match
		}
		if ($existingEntry) {
			// Optionally, handle existing entry (e.g., return an error or update the entry)
			return false;
		}

		// If it doesn't exist, call the parent insert method
		return parent::insert($data);
	}

	public function getProductsAndImages($buyerId) {
		// fetch all items in the user's wishlist
		$userWishlist = $this->getAllByColumnValue('buyer_id', $buyerId);

		$products = [];
		foreach($userWishlist as $wishlistItem) {
			$product = $this->productModel->getByColumnValue('product_id', $wishlistItem['product_id']);

			// Must be an array if it holds values for a product
			if(is_array($product)) // add it to products
				array_push($products, $product);
		}

		// set default in case no images found
		$images = [];
		foreach($products as $product) {
			// fetch all Product_Image entries with same id
			$productImage = $this->productImageModel->getByColumnValue('product_id', $product['product_id']);

			if(is_array($productImage) && isset($productImage['product_image_url'])) {
				// extract the file's name
				$productImageUrl = $productImage['product_image_url'];
				// add it to images
				array_push($images, $productImageUrl);
			}
		}

		return [
			'products' => $products,
			'images' => $images,
		];
	}
}
