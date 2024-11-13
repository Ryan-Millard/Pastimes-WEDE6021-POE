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
    ['get', '', [$controller('home'), 'index']],
    ['get', '/home', [$controller('home'), 'index']],
    ['get', '/products/{id}', [$controller('home'), 'showProductById']],
    ['post', '/products/{id}', [$controller('home'), 'handleWishlistPost']],
    ['post', '/addProduct', [$controller('product'), 'addProduct']],
    ['get', '/categories', [$controller('category'), 'showAll']],
    ['get', '/categories/{id}', [$controller('category'), 'showById']],
    ['get', '/signup', [$controller('user'), 'showSignUpForm']],
    ['post', '/signup', [$controller('user'), 'signup']],
    ['get', '/login', [$controller('user'), 'showLoginForm']],
    ['post', '/login', [$controller('user'), 'login']],
    ['get', '/logout', [$controller('user'), 'logout']],
    ['get', '/admin', [$controller('admin'), 'showDashboard']],
    ['post', '/admin/products/updateStatus', [$controller('admin'), 'handleAdminModerationChoice']],
    ['get', '/admin/products/editProduct/{id}', [$controller('admin'), 'editProduct']],
    ['post', '/admin/products/updateProduct/{id}', [$controller('admin'), 'updateProduct']],
    ['get', '/admin/users/{id}', [$controller('admin'), 'showUserById']],
    ['post', '/admin/users/{id}', [$controller('admin'), 'moderateUser']],
    ['get', '/dashboard', [$controller('dashboard'), 'showDashboard']],
    ['post', '/dashboard', [$controller('dashboard'), 'emptyWishlist']],
    ['get', '/messages', [$controller('message'), 'showAll']],
    ['get', '/messages/{id}', [$controller('message'), 'getConversation']],
    ['post', '/messages/send', [$controller('message'), 'sendMessage']],
    ['get', '/checkout', [$controller('product'), 'displayCheckout']],
    ['post', '/checkout', [$controller('product'), 'processCheckout']],
    ['get', '/purchases', [$controller('purchase'), 'getAllTransactionsForUser']],
    ['get', '/purchases/{id}', [$controller('purchase'), 'getTransactionById']],
];

// Define middleware configurations
$middleware_configs = [
    // Auth middleware - User must be logged in
    ['auth' => [
        '/dashboard',
        '/admin',
        '/admin/products/updateStatus',
        '/admin/users/{id}',
        '/logout',
        '/messages',
        '/messages/{id}',
        '/messages/send'
    ]],
    
    // Admin middleware - User must be admin
    ['admin' => [
        ['/admin', [$model('admin')]],
        ['/admin/products/updateStatus', [$model('admin')]],
        ['/admin/products/editProduct/{id}', [$model('admin')]],
        ['/admin/products/updateProduct/{id}', [$model('admin')]],
        ['/admin/users/{id}', [$model('admin')]]
    ]],
    
    // Seller middleware - User must be seller
    ['seller' => [
        '/addProduct'
    ]],
    
    // Buyer middleware - User must be buyer
    ['buyer' => [
        '/checkout',
        '/purchases',
        '/purchases/{id}'
    ]],
    
    // Guest middleware - User must NOT be logged in
    ['guest' => [
        '/signup',
        '/login'
    ]]
];

// Register routes
foreach($routes as [$method, $path, $action]) {
    $router->$method(PASTIMES_BASE . $path, $action);
}

// Register middleware
foreach($middleware_configs as $config) {
    foreach($config as $type => $paths) {
        foreach($paths as $path) {
            if (is_array($path)) {
                // For middleware with additional parameters (like admin middleware with model)
                [$routePath, $additionalParams] = $path;
                $router->addMiddleware(
                    PASTIMES_BASE . $routePath, 
                    [$middleware($type), 'handle'],
                    $additionalParams
                );
            } else {
                // For simple middleware without additional parameters
                $router->addMiddleware(
                    PASTIMES_BASE . $path, 
                    [$middleware($type), 'handle']
                );
            }
        }
    }
}

// Set the error controller as a callback to render the error view
$router->setErrorCallback([$controller('error404'), 'show404']);

// Resolve the route
$router->resolve();
