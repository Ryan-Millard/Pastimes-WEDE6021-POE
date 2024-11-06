<?php

namespace App\Controllers;

require_once __DIR__ . './../models/WishlistModel.php';
require_once __DIR__ . './../models/BuyerModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\WishlistModel;
use App\Models\BuyerModel;
use App\Controllers\Controller;

class DashboardController extends Controller {
	protected $wishlistModel;
	protected $buyerModel;

	public function __construct(WishlistModel $wishlistModel = null, BuyerModel $buyerModel = null) {
		parent::__construct();

		$this->wishlistModel = $wishlistModel;
		$this->buyerModel = $buyerModel;
	}

	public function showDashboard() {
		$userId = $_SESSION['user']['user_id'];
		$buyer = $this->buyerModel->getByUserId($userId);
		// User is a buyer
		if($buyer) {
			$this->showBuyerDashboard($buyer);
			return;
		}
		$this->render('userDashboard');
	}

	private function showBuyerDashboard($buyer) {
		$buyerId = $buyer['buyer_id'];

		$wishlistProductsAndImages = $this->wishlistModel->getProductsAndImages($buyerId);
		$wishlistData = $this->wishlistModel->getAllByColumnValue('buyer_id', $buyerId);

		$quantities = [];
		foreach($wishlistData as $wishlist)
			$quantities[] = $wishlist['quantity'];
		[
			'products' => $products,
			'images' => $images,
		] = $wishlistProductsAndImages;
		$userType = null;
		$this->setData([
			'products' => $products,
			'images' => $images,
			'quantities' => $quantities,
			'productListHeading' => 'Wishlist',
			'noProductFoundMessage' => 'There are no items in your wishlist.',
			'containerId' => 'wishlist',
			'userType' => 'buyer',
		]);
		$this->render('userDashboard');
	}
}
