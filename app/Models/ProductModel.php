<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class ProductModel extends Model {
	protected $productImageModel;

	public function __construct(Model $productImageModel) {
		parent::__construct();
		$this->tableName = 'Products';
		$this->tablePrimaryKey = 'product_id';

		$this->productImageModel = $productImageModel;
	}

	public function getAllPending() {
		return $this->getAllByColumnValue('product_status', 'pending');
	}

	// Function to decrease the quantity_available field
	public function decreaseQuantity($productId, $quantity) {
		// Ensure quantity is a positive integer and productId is valid
		if ($quantity <= 0) {
			throw new Exception("Quantity to decrease must be a positive number.");
		}

		// Fetch the current quantity available for the product
		$product = $this->getByColumnValue('product_id', $productId);
		if (!$product) {
			throw new Exception("Product not found with ID: $productId");
		}

		$currentQuantity = $product['quantity_available'];

		// Ensure there's enough quantity to decrease
		if ($currentQuantity < $quantity) {
			throw new \Exception("Not enough quantity available to decrease by $quantity.");
		}

		// Calculate the new quantity
		$newQuantity = $currentQuantity - $quantity;

		// Update the product's quantity_available field
		$data = ['quantity_available' => $newQuantity];
		return $this->update($productId, $data); // Update the record and return the updated data
	}

	public function getProductImageUrl($productId) {
		$productImage = $this->productImageModel->getByColumnValue('product_id', $productId);

		return $productImage['product_image_url'];
	}
}
