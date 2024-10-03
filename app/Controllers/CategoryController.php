<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . './../models/CategoryModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Model;
use App\Controllers\Controller;

class CategoryController extends Controller {
	protected $productModel;
	protected $productImageModel;
	protected $sellerModel;
	protected $userModel;
	protected $categoryModel;

	public function __construct(Model $productModel = null, Model $productImageModel = null,
								Model $sellerModel = null, Model $userModel = null,
								Model $categoryModel = null) {
		parent::__construct();

		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
		$this->sellerModel = $sellerModel;
		$this->userModel = $userModel;
		$this->categoryModel = $categoryModel;
	}

	// list categories
	public function showAll() {
		// fetch categories and products
		$categories = $this->categoryModel->getAll();
		$products = $this->productModel->getAll();

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

		$this->setData([
			'categories' => $categories,
			'products' => $products,
			'images' => $images,
		]);
		$this->render('category_list', 'product_list');
	}

	// show categories by ID along with products in the category
	public function showById($id) {
		$category = $this->categoryModel->getByColumnValue('category_id', $id);
		$products = $this->productModel->getAllByColumnValue('category_id', $id);

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

		$this->setData([
			'category' => $category,
			'products' => $products,
			'images' => $images,
		]);
		$this->render('single_category', 'product_list');
	}
}
