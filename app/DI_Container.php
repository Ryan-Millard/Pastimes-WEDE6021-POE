<?php

	namespace App;

	require_once __DIR__ . '/Controllers/HomeController.php';
	require_once __DIR__ . '/Controllers/UserController.php';
	require_once __DIR__ . '/Controllers/CategoryController.php';
	require_once __DIR__ . '/Controllers/DashboardController.php';
	require_once __DIR__ . '/Controllers/AdminController.php';
	require_once __DIR__ . '/Controllers/Error404Controller.php';
	require_once __DIR__ . '/Controllers/ProductController.php';
	require_once __DIR__ . '/Controllers/MessageController.php';
	require_once __DIR__ . '/Controllers/PurchaseController.php';

	require_once '../app/Middleware/AuthMiddleware.php';
	require_once '../app/Middleware/AdminMiddleware.php';
	require_once '../app/Middleware/SellerMiddleware.php';
	require_once '../app/Middleware/GuestMiddleware.php';
	require_once '../app/Middleware/BuyerMiddleware.php';

	require_once 'Models/MessageModel.php';
	require_once 'Models/TransactionModel.php';
	require_once 'Models/TransactionProductModel.php';

	use \App\Controllers\HomeController;
	use \App\Controllers\UserController;
	use \App\Controllers\CategoryController;
	use \App\Controllers\DashboardController;
	use \App\Controllers\AdminController;
	use \App\Controllers\Error404Controller;
	use \App\Controllers\ProductController;
	use \App\Controllers\MessageController;
	use \App\Controllers\PurchaseController;

	use \App\Models\CategoryModel;
	use \App\Models\UserModel;
	use \App\Models\AdminModel;
	use App\Models\BuyerModel;
	use App\Models\SellerModel;
	use App\Models\ProductModel;
	use App\Models\ProductImageModel;
	use App\Models\WishlistModel;
	use App\Models\MessageModel;
	use \App\Models\TransactionModel;
	use \App\Models\TransactionProductModel;

	use \App\Middleware\AuthMiddleware;
	use \App\Middleware\AdminMiddleware;
	use \App\Middleware\SellerMiddleware;
	use \App\Middleware\GuestMiddleware;
	use \App\Middleware\BuyerMiddleware;

	class DI_Container {
		private static $controllerInstances = [];
		private static $modelInstances = [];
		private static $middlewareInstances = [];

		public static function setController($key, $value) {
			self::$controllerInstances[$key] = $value;
		}

		public static function getController($key) {
			return self::$controllerInstances[$key] ?? null;
		}

		public static function setModel($key, $value) {
			self::$modelInstances[$key] = $value;
		}

		public static function getModel($key) {
			return self::$modelInstances[$key] ?? null;
		}

		public static function setMiddleware($key, $value) {
			self::$middlewareInstances[$key] = $value;
		}

		public static function getMiddleware($key) {
			return self::$middlewareInstances[$key] ?? null;
		}

		public static function init() {
			self::initModels();
			self::initControllers();
			self::initMiddleware();
		}

		private static function initControllers() {
			self::setController('home', new HomeController(self::getModel('product'), self::getModel('productImage'), self::getModel('seller'), self::getModel('user'), self::getModel('category'), self::getModel('buyer'), self::getModel('wishlist')));
			self::setController('category', new CategoryController(self::getModel('product'), self::getModel('productImage'), self::getModel('seller'), self::getModel('user'), self::getModel('category')));
			self::setController('user', new UserController(self::getModel('user'), self::getModel('seller'), self::getModel('buyer'), self::getModel('admin')));
			self::setController('dashboard', new DashboardController(self::getModel('wishlist'), self::getModel('buyer'), self::getModel('seller')));
			self::setController('admin', new AdminController(self::getModel('admin'), self::getModel('user'), self::getModel('buyer'), self::getModel('seller'), self::getModel('product'), self::getModel('productImage'), self::getModel('category')));
			self::setController('product', new ProductController(self::getModel('product'), self::getModel('productImage'), self::getModel('seller'), self::getModel('category'), self::getModel('wishlist'), self::getModel('buyer'), self::getModel('transaction'), self::getModel('transactionProduct'), self::getModel('message')));
			self::setController('message', new MessageController(self::getModel('message'), self::getModel('user')));
			self::setController('error404', new Error404Controller(self::getModel('error404')));
			self::setController('purchase', new PurchaseController(self::getModel('transaction'), self::getModel('transactionProduct'), self::getModel('product'), self::getModel('buyer'), self::getModel('seller')));
		}

		private static function initModels() {
			self::setModel('home', null);
			self::setModel('category', new CategoryModel());
			self::setModel('user', new UserModel());
			self::setModel('admin', new AdminModel());
			self::setModel('buyer', new BuyerModel());
			self::setModel('productImage', new ProductImageModel());
			self::setModel('product', new ProductModel(self::getModel('productImage')));
			self::setModel('error404', null);
			self::setModel('seller', new SellerModel(self::getModel('product'), self::getModel('productImage')));
			self::setModel('message', new MessageModel());
			self::setModel('transaction', new TransactionModel());
			self::setModel('transactionProduct', new TransactionProductModel());

			// Initialize WishlistModel after product and productImage models
			self::setModel('wishlist', new WishlistModel(self::getModel('productImage'), self::getModel('product')));
		}


		private static function initMiddleware() {
			self::setMiddleware('auth', new AuthMiddleware());
			self::setMiddleware('admin', new AdminMiddleware());
			self::setMiddleware('seller', new SellerMiddleware());
			self::setMiddleware('guest', new GuestMiddleware());
			self::setMiddleware('buyer', new BuyerMiddleware());
		}
	}

