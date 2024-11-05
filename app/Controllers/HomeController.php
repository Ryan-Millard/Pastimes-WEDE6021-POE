<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . './../models/ProductImageModel.php';
require_once __DIR__ . './../models/BuyerModel.php';
require_once __DIR__ . './../models/WishlistModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Model;
use App\Models\BuyerModel;
use App\Models\WishlistModel;
use App\Controllers\Controller;

class HomeController extends Controller {
	protected $productModel;
	protected $productImageModel;
	protected $sellerModel;
	protected $userModel;
	protected $categoryModel;
	protected $buyerModel;
	protected $wishlistModel;

	public function __construct(Model $productModel = null, Model $productImageModel = null,
								Model $sellerModel = null, Model $userModel = null,
								Model $categoryModel = null,
								Model $buyerModel = null,
								Model $wishlistModel = null
	) {
		parent::__construct();

		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
		$this->sellerModel = $sellerModel;
		$this->userModel = $userModel;
		$this->categoryModel = $categoryModel;
		$this->buyerModel = $buyerModel;
		$this->wishlistModel = $wishlistModel;
	}

	public function index() {
		// fetch products
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
			'products' => $products,
			'images' => $images,
		]);
		$this->render('home', 'product_list');
	}

	public function showProductById($id) {
		// set default values in case there is no product with arg's id value
		$product = '';
		$seller_rating = '';
		$username = '';
		$category = '';
		$productImage = '';
		$image = '';

		// fetch data by respective id
		$product = $this->productModel->getByColumnValue('product_id', $id);
		if(!empty($product)) {	// ensure there is a product with the arg's id
			// fetch seller data
			$seller = $this->sellerModel->getByColumnValue('seller_id', $product['seller_id']);
			// retrieve seller's rating
			$seller_rating = $seller['seller_rating'];

			// fetch user data
			$user = $this->userModel->getByColumnValue('user_id', $seller['user_id']);
			// set username
			$username = $user['username'];

			// fetch user, category and product image using respective IDs
			$category = $this->categoryModel->getByColumnValue('category_id', $product['category_id']);
			$productImage = $this->productImageModel->getByColumnValue('product_id', $product['product_id']);

			if(!empty($productImage)) {
				// fetch image from product images based on image's url
				// $image = string|false
				// string -> valid img
				$image = $this->productImageModel->getImageByName($productImage['product_image_url']);
			}
		}

		$this->setData([
			'product' => $product,
			'image' => $image,
			'seller_rating' => $seller_rating,
			'username' => $username,
			'category' => $category
		]);
		$this->render('single_product');
	}

	public function addToWishlist() {
		$flash_message = null;
		['product_id' => $productId, 'quantity' => $productQuantity] = $_POST;
		['user_id' => $userId] = $_SESSION['user'];
		['buyer_id' => $buyerId] = $this->buyerModel->getByColumnValue('user_id', $userId);

		$result = false;
		try {
			$insertData = [
				'buyer_id' => $buyerId,
				'product_id' => (int) $productId,
				'quantity' => $productQuantity,
			];
			$result = $this->wishlistModel->insert($insertData);
		} catch(\Exception $e) {
			echo 'Error: ' . $e->getMessage();
			$flash_message = 'An error occurred. Please try again in a few minutes';
		}

		if(!isset($flash_message))
			$flash_message = ($result) ? 'Added to Wishlist' : 'This item is already in your wishlist';
		$_SESSION['flash_message'] = $flash_message;
		$this->redirect('/pastimes/products/' . $_POST['product_id']);
	}
}
