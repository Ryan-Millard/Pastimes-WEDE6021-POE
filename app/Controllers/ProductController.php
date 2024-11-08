<?php

namespace App\Controllers;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . './../models/Model.php';

use App\Models\Model;
use App\Controllers\Controller;

class ProductController extends Controller {
	protected $productModel;
	protected $productImageModel;
	protected $sellerModel;
	protected $categoryModel;

	public function __construct(
		Model $productModel,
		Model $productImageModel,
		Model $sellerModel,
		Model $categoryModel
	) {
		parent::__construct();

		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
		$this->sellerModel = $sellerModel;
		$this->categoryModel= $categoryModel;
	}

	public function addProduct() {
		$userId = (int)$_SESSION['user']['user_id'];
		// filter out optional fields that the user chose not to enter
		$productData = array_filter($_POST, fn($value) => $value !== "");

		// default since new, admin must approve
		$productData['product_status'] = 'pending';

		// Check that the category name is valid
		// Get category details
		$categoryData = $this->categoryModel->getByColumnValue('category_name', $productData['product_category']);
		// Replace 'product_category' with 'category_id'
		$productData['category_id'] = $categoryData['category_id'];  // Add the category_id
		unset($productData['product_category']); // Remove the old 'product_category'

		// Get the seller's details
		$sellerData = $this->sellerModel->getByUserId($userId);
		$productData['seller_id'] = $sellerData['seller_id'];
		// echo '<pre>';
		// echo var_dump($productData);
		// echo '</pre><br />';

		$newProductId = $this->productModel->insert($productData);
		echo '<pre>';
		echo var_dump($newProductId);
		echo '</pre><br />';

		$newProductImage = $this->productImageModel->insertImage($_FILES['image'], $newProductId);
		// check enums
	}
}

