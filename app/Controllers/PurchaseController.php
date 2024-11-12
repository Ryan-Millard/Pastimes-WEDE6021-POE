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
	) {
		parent::__construct();

		$this->transactionModel = $transactionModel;
		$this->transactionProductModel= $transactionProductModel;
		$this->productModel= $productModel;
	}

	public function getAllTransactionsForUser() {
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
