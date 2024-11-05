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
		$buyer = $this->buyerModel->getByColumnValue('user_id', $userId);
		$buyerId = $buyer['buyer_id'];

		$wishlistData = $this->wishlistModel->getProductsAndImages($buyerId);

		['products' => $products, 'images' => $images] = $wishlistData;
		$this->setData([
			'products' => $products,
			'images' => $images,
			'noProductFoundMessage' => 'There are no items in your wishlist.',
			'containerId' => 'wishlist',
		]);
		$this->render('userDashboard', 'product_list');
	}
}
