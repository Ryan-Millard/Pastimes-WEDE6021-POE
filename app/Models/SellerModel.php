<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class SellerModel extends Model {
	protected $productModel;
	protected $productImageModel;

	public function __construct(Model $productModel = null, Model $productImageModel = null) {
		parent::__construct();
		$this->tableName = 'Sellers';

		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
	}

	public function getByUserId($userId) {
		return $this->getByColumnValue('user_id', $userId);
	}


	// Function to get products and associated image URLs for a specific seller
	public function getProductsAndImages($sellerId) {
		$products = $this->productModel->getAllByColumnValue('seller_id', $sellerId);

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

