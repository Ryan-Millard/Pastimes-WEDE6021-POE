<?php

	namespace App;

	require_once __DIR__ . '/Controllers/HomeController.php';
	require_once __DIR__ . '/Controllers/UserController.php';
	require_once __DIR__ . '/Controllers/CategoryController.php';
	require_once __DIR__ . '/Controllers/DashboardController.php';
	require_once __DIR__ . '/Controllers/AdminController.php';
	require_once __DIR__ . '/Controllers/Error404Controller.php';
	require_once __DIR__ . '/Controllers/ProductController.php';

	require_once '../app/Middleware/AuthMiddleware.php';
	require_once '../app/Middleware/AdminMiddleware.php';

	use \App\Controllers\HomeController;
	use \App\Controllers\UserController;
	use \App\Controllers\CategoryController;
	use \App\Controllers\DashboardController;
	use \App\Controllers\AdminController;
	use \App\Controllers\Error404Controller;
	use \App\Controllers\ProductController;

	use \App\Models\CategoryModel;
	use \App\Models\UserModel;
	use \App\Models\AdminModel;
	use App\Models\BuyerModel;
	use App\Models\SellerModel;
	use App\Models\ProductModel;
	use App\Models\ProductImageModel;

	use \App\Middleware\AuthMiddleware;
	use \App\Middleware\AdminMiddleware;

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
			self::setController('home', new HomeController(self::getModel('product'), self::getModel('productImage'), self::getModel('seller'), self::getModel('user'), self::getModel('category')));
			self::setController('category', new CategoryController(self::getModel('product'), self::getModel('productImage'), self::getModel('seller'), self::getModel('user'), self::getModel('category')));
			self::setController('user', new UserController(self::getModel('user')));
			self::setController('dashboard', new DashboardController(self::getModel('dashboard')));
			self::setController('admin', new AdminController(self::getModel('admin'), self::getModel('user'), self::getModel('buyer'), self::getModel('seller')));
			self::setController('product', new ProductController(self::getModel('product')));
			self::setController('error404', new Error404Controller(self::getModel('error404')));
		}

		private static function initModels() {
			self::setModel('home', null);
			self::setModel('category', new CategoryModel());
			self::setModel('user', new UserModel());
			self::setModel('dashboard', null);
			self::setModel('admin', new AdminModel());
			self::setModel('buyer', new BuyerModel());
			self::setModel('seller', new SellerModel());
			self::setModel('product', new ProductModel());
			self::setModel('productImage', new ProductImageModel());
			self::setModel('error404', null);
		}

		private static function initMiddleware() {
			self::setMiddleware('auth', new AuthMiddleware());
			self::setMiddleware('admin', new AdminMiddleware());
		}
	}

