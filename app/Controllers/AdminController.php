<?php

namespace App\Controllers;

require_once __DIR__ . './../models/UserModel.php';
require_once __DIR__ . './../models/AdminModel.php';
require_once __DIR__ . './../models/BuyerModel.php';
require_once __DIR__ . './../models/SellerModel.php';
require_once __DIR__ . './../models/ProductModel.php';
require_once __DIR__ . './../models/ProductImageModel.php';
require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . '/Controller.php';

use App\Models\UserModel;
use App\Models\AdminModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\Model;

class AdminController extends Controller {
	protected $userModel;
	protected $adminModel;
	protected $buyerModel;
	protected $sellerModel;
	protected $productModel;
	protected $categoryModel;

	public function __construct(
		AdminModel $adminModel = null,
		UserModel $userModel = null,
		BuyerModel $buyerModel = null,
		SellerModel $sellerModel = null,
		ProductModel $productModel = null,
		ProductImageModel $productImageModel = null,
		Model $categoryModel = null
	) {
		$this->adminModel = $adminModel;
		$this->userModel = $userModel;
		$this->buyerModel = $buyerModel;
		$this->sellerModel = $sellerModel;
		$this->categoryModel = $categoryModel;
		$this->productModel = $productModel;
		$this->productImageModel = $productImageModel;
	}

	public function showDashboard() {
		$unapprovedUsers = $this->userModel->getUnapprovedUsers();
		$pendingProducts = $this->productModel->getAllPending();

		// set default in case no images found
		$images = [];
		foreach($pendingProducts as $product) {
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
			'users' => $unapprovedUsers,
			'products' => $pendingProducts,
			'images' => $images,
			'noProductListHeading' => true,
		]);
		$this->render('adminDashboard');
	}

	public function showUserById($id) {
		$user = $this->userModel->getByColumnValue('user_id', $id);
		if (empty($user)) {
			$this->setFlashMessage('That user could not be found');
			return $this->redirect('/pastimes/admin');
		}

		$this->setData(['user' => $user]);
		$this->render('single_user');
	}

	public function moderateUser($id) {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return $this->redirect('/pastimes/admin/users/' . $id);
		}

		if ($_POST['approve'] === "0") {
			$this->userModel->deleteByColumnValue('user_id', $id);
			$this->setFlashMessage('User has been deleted successfully.');
			return $this->redirect('/pastimes/admin');
		}

		if ($_POST['approve'] !== "1") {
			$this->setFlashMessage('An error has occurred. Please try again.');
			return $this->redirect('/pastimes/admin/users/' . $id);
		}

		$this->registerUser($id, $_POST['role']);
	}

	private function registerUser($id, $role) {
		$dataForInsert = ['user_id' => $id];

		switch ($role) {
		case "seller":
			$this->checkDuplicateAndInsert($this->sellerModel, $dataForInsert, 'seller', $id);
			break;
		case "buyer":
			$this->checkDuplicateAndInsert($this->buyerModel, $dataForInsert, 'buyer', $id);
			break;
		case "admin":
			$this->checkDuplicateAndInsert($this->adminModel, $dataForInsert, 'admin', $id);
			break;
		default:
			$this->setFlashMessage('An error has occurred. Please try again.');
			return $this->redirect('/pastimes/admin/users/' . $id);
		}
	}

	private function checkDuplicateAndInsert($model, $data, $role, $id) {
		if ($model->getByColumnValue($role . '_id', $id)) {
			$this->setFlashMessage("That user has already been registered as a $role.");
		} else {
			$model->insert($data);
			$this->setFlashMessage("That user has been successfully registered as a $role.");
		}
		return $this->redirect('/pastimes/admin');
	}

	private function setFlashMessage($message) {
		$_SESSION['flash_message'] = $message;
	}

	public function handleAdminModerationChoice() {
		if(isset($_POST['approve']))
			return $this->updateProductStatus();
	}

	public function updateProductStatus() {
		$newStatus = $_POST['approve'] ? 'approved' : 'rejected';

		$updatedProduct = $this->productModel->update($_POST['product_id'], ['product_status' => $newStatus]);

		$instructions = ($newStatus === 'rejected') ? ".<br /><br />Please tell the seller why the product was rejected" : '';
		$this->setFlashMessage('The product has successfully been ' . $newStatus . $instructions . '.');

		if($newStatus === 'approved')
			$this->redirect('/pastimes/admin');
		else
			$this->redirect('/pastimes/messages/' . $_POST['user_id']);
	}

	public function editProduct($id) {
		// ----------------------------------------------------------------------------------------
		// STEP 1: Fetch seller and product data
		// ----------------------------------------------------------------------------------------
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

			// fetch Seller's data
			$user = $this->userModel->getByColumnValue('user_id', $seller['user_id']);
			// set seller's username
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
		// ----------------------------------------------------------------------------------------
		// STEP 2: Fetch buyer data and quantity in wishlist (if in wishlist)
		// ----------------------------------------------------------------------------------------

		// fetch the details of the user that is currently logged in
		$buyer = null;
		if(isset($_SESSION['user']['user_id']))
			$buyer = $this->buyerModel->getByUserId($_SESSION['user']['user_id']);
		// initialise a default value, see elaboration below
		$wishlistItemQuantity = 0;
		if($buyer) {
			$buyerId = $buyer['buyer_id'];
			$productId = $id;	// $id is passed to this method by the routing system
			// fetch logged in user's wishlist to pass quantity to the view
			$wishlist = $this->wishlistModel->getByMultipleColumnValues([
				'buyer_id' => $buyerId,
				'product_id' => $productId,
			]);

			$wishlistItemQuantity = ($wishlist) ? $wishlist['quantity'] : 0;
		}

		$this->setData([
			'product' => $product,
			'image' => $image,
			'seller_rating' => $seller_rating,
			'username' => $username,
			'user_id' => $user['user_id'],
			'category' => $category,
			'user_is_buyer' => ($buyer) ? true : false,
			// quantity
			// 		0: item not in wishlist
			// 		>0: item in the wishlist
			'quantity' => $wishlistItemQuantity
		]);
		$this->render('edit_product');
	}

	public function updateProduct($productId) {
		$this->setFlashMessage('The product has successfully been updated.');

		if((int)$_POST['approve'] === 0) {
			$this->productModel->update($productId, [
				'product_status' => 'rejected'
			]);
			return $this->redirect('/pastimes/admin');
		}

		$category = $this->categoryModel->getByColumnValue('category_name', $_POST['product_category']);
		try {
			$this->productModel->update($productId, [
				'product_name' => $_POST['product_name'],
				'product_condition' => $_POST['product_condition'],
				'price' => $_POST['price'],
				'category_id' => $category['category_id'],
				'product_status' => 'approved'
			]);
		} catch(\Exception $e) {
		}

		return $this->redirect('/pastimes/admin');
	}
}
