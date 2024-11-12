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
	protected $wishlistModel;
	protected $buyerModel;
	protected $transactionModel;
	protected $transactionProductModel;
	protected $messageModel;

	public function __construct(
		Model $productModel,
		Model $productImageModel,
		Model $sellerModel,
		Model $categoryModel,
		Model $wishlistModel,
		Model $buyerModel,
		Model $transactionModel,
		Model $transactionProductModel,
		Model $messageModel,
	) {
		parent::__construct();

		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
		$this->sellerModel = $sellerModel;
		$this->categoryModel= $categoryModel;
		$this->wishlistModel = $wishlistModel;
		$this->buyerModel = $buyerModel;
		$this->transactionModel = $transactionModel;
		$this->transactionProductModel= $transactionProductModel;
		$this->messageModel= $messageModel;
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

	public function displayCheckout() {
		$userId = $_SESSION['user']['user_id'];
		$buyer = $this->buyerModel->getByUserId($userId);
		$buyerId = $buyer['buyer_id'];
		[
			'products' => $products,
			'images' => $images
		] = $this->wishlistModel->getProductsAndImages($buyerId);

		$wishlist = $this->wishlistModel->getAllByColumnValue('buyer_id', $buyerId);

		$this->setData([
			'products' => $products,
			'images' => $images,
			'wishlist' => $wishlist
		]);
		return $this->render('checkout');
	}

	public function processCheckout() {
		$userId = $_SESSION['user']['user_id'];

		$buyer = $this->buyerModel->getByUserId($userId);
		$buyerId = $buyer['buyer_id'];

		$wishlist = $this->wishlistModel->getAllByColumnValue('buyer_id', $buyerId);

		// Log new transaction
		$transactionDataForInsert = [
			'buyer_id' => $buyerId,
			'total_price' => $_POST['total_price'],
			'shipping_address' => $_POST['address'],
			'payment_method' => $_POST['payment_method'],
		];
		$transactionId = $this->transactionModel->insert($transactionDataForInsert);
		$transaction = $this->transactionModel->getByColumnValue('transaction_id', $transactionId);

		$count = 0;
		// Insert all products purchased & delete from wishlist
		foreach($wishlist as $purchasedProduct) {
			$productId = $purchasedProduct['product_id'];
			$quantityPurchased = $purchasedProduct['quantity'];
			// decrease quantity available
			$this->productModel->decreaseQuantity($productId, $quantityPurchased);
			// get the product
			$product = $this->productModel->getByColumnValue('product_id', $productId);

			// get seller
			$seller = $this->sellerModel->getByColumnValue('seller_id', $product['seller_id']);
			// get the seller's id
			$sellerId = $seller['user_id'];

			// get currently logged in user's (buyer's) id
			$currentUserId = $_SESSION['user']['user_id'];

			$this->messageModel->insert([
				'sender_id' => $currentUserId,
				'receiver_id' => $sellerId,
				'message' => 'This user has purchased ' . 
							$quantityPurchased . ' ' .
							$product['product_name'] . 
							'(s) from you, with reference number: ' . 
							$transaction['reference_number'],
			]);

			// Insert purchased products
			$this->transactionProductModel->insert([
				'transaction_id' => $transactionId,
				'product_id' => $productId,
				'quantity' => $quantityPurchased,
			]);

			// Remove the items the user bought from their wishlist
			$this->wishlistModel->deleteByColumnsValues([
				'buyer_id' => $buyerId,
				'product_id' => $productId,
			]);
		}

		$_SESSION['flash_message'] = 'Transaction completed successfully';

		$this->redirect('/pastimes/purchases/' . $transactionId);
	}
}
