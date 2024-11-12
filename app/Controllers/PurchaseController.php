<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Model;
use App\Controllers\Controller;

class PurchaseController extends Controller {
	protected $transactionModel;
	protected $transactionProductModel;
	protected $productModel;

	public function __construct(
		Model $transactionModel,
		Model $transactionProductModel,
		Model $productModel,
		Model $buyerModel,
		Model $sellerModel,
	) {
		parent::__construct();

		$this->transactionModel = $transactionModel;
		$this->transactionProductModel= $transactionProductModel;
		$this->productModel= $productModel;
		$this->buyerModel= $buyerModel;
		$this->sellerModel= $sellerModel;
	}

	public function getAllTransactionsForUser() {
		$userId = $_SESSION['user']['user_id'];

		// get user's buyer details
		$buyer = $this->buyerModel->getByUserId($userId);
		if(!$buyer) {
			$_SESSION['flash_message'] = 'Only buyers have access to that page.';
			return $this->redirect('/pastimes');
		}

		$purchases = $this->transactionModel->getAllByColumnValue('buyer_id', $buyer['buyer_id']);

		$this->setData([
			'purchases' => $purchases,
		]);
		return $this->render('transactions_list');
	}

	public function getTransactionById($id) {
		$transaction = $this->transactionModel->getById($id);

		$transactionProducts = $this->transactionProductModel->getAllByTransactionId($id);

		$products = [];
		$images = [];
		foreach($transactionProducts as $product) {
			$products[] = $this->productModel->getByColumnValue('product_id', $product['product_id']);
			$images[] = $this->productModel->getProductImageUrl($product['product_id']);
		}

		$this->setData([
			'transaction' => $transaction,
			'transactionProducts' => $transactionProducts,
			'products' => $products,
			'images' => $images,
		]);
		$this->render('single_transaction');
	}
}
