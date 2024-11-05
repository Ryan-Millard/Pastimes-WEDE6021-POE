<?php

namespace App;

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/DI_Container.php';

// Initialize the router
$router = new \App\Core\Router();
DI_Container::init();

// Create simple aliases for get methods
$controller = fn($controllerName) => DI_Container::getController($controllerName);
$model = fn($modelName) => DI_Container::getModel($modelName);
$middleware = fn($middlewareName) => DI_Container::getMiddleware($middlewareName);

// Define constants for base paths
define('PASTIMES_BASE', '/pastimes');

// Define routes
$routes = [
	['get', PASTIMES_BASE, [$controller('home'), 'index']],
	['get', PASTIMES_BASE . '/home', [$controller('home'), 'index']],
	['get', PASTIMES_BASE . '/products/{id}', [$controller('home'), 'showProductById']],
	['post', PASTIMES_BASE . '/products/{id}', [$controller('home'), 'addToWishlist']],
	['get', PASTIMES_BASE . '/categories', [$controller('category'), 'showAll']],
	['get', PASTIMES_BASE . '/categories/{id}', [$controller('category'), 'showById']],
	['get', PASTIMES_BASE . '/signup', [$controller('user'), 'showSignUpForm']],
	['post', PASTIMES_BASE . '/signup', [$controller('user'), 'signup']],
	['get', PASTIMES_BASE . '/login', [$controller('user'), 'showLoginForm']],
	['post', PASTIMES_BASE . '/login', [$controller('user'), 'login']],
	['get', PASTIMES_BASE . '/logout', [$controller('user'), 'logout']],
	['get', PASTIMES_BASE . '/admin', [$controller('admin'), 'showDashboard']],
	['get', PASTIMES_BASE . '/admin/users/{id}', [$controller('admin'), 'showUserById']],
	['post', PASTIMES_BASE . '/admin/users/{id}', [$controller('admin'), 'moderateUser']],
	['get', PASTIMES_BASE . '/dashboard', [$controller('dashboard'), 'showDashboard']]
];

// Register routes
foreach($routes as [$method, $path, $action])
	$router->$method($path, $action);

// Apply middleware
$router->addMiddleware(PASTIMES_BASE . '/dashboard', [$middleware('auth'), 'handle']);
$router->addMiddleware(PASTIMES_BASE . '/admin', [$middleware('auth'), 'handle']);
$router->addMiddleware(PASTIMES_BASE . '/admin', [$middleware('admin'), 'handle'], [$model('admin')]);
$router->addMiddleware(PASTIMES_BASE . '/admin/users/{id}', [$middleware('auth'), 'handle']);
$router->addMiddleware(PASTIMES_BASE . '/admin/users/{id}', [$middleware('admin'), 'handle'], [$model('admin')]);

// Set the error controller as a callback to render the error view
$router->setErrorCallback([$controller('error404'), 'show404']);

// Resolve the route
$router->resolve();
