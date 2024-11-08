<?php

namespace App\Core;

class Router {
	// array to map URLs to their respective Controllers
	private $routes = [];
	// array to store & apply middleware
	private $middleware = [];
	// Controller used for 404 errors
	private $errorCallback;

	// Register a GET route
	public function get($path, $callback) {
		$this->routes['GET'][$this->formatRoute($path)] = $callback;
	}

	// Register a POST route
	public function post($path, $callback) {
		$this->routes['POST'][$this->formatRoute($path)] = $callback;
	}

	// Set the error callback
	public function setErrorCallback($callback) {
		$this->errorCallback = $callback;
	}

	// Register middleware for a specific route (allowing multiple middleware per route)
	public function addMiddleware($path, $middleware, $args = []) {
		$formattedPath = $this->formatRoute($path);

		// Ensure that middleware for a route is stored as an array (supporting multiple middleware)
		if (!isset($this->middleware[$formattedPath])) {
			$this->middleware[$formattedPath] = [];
		}

		$this->middleware[$formattedPath][] = [
			'middleware' => $middleware,
			'args' => $args
		];
	}


	// Resolve the current route
	public function resolve() {
		$method = $_SERVER['REQUEST_METHOD'];
		$path = $this->formatRoute($_SERVER['REQUEST_URI']);

		if (!isset($this->routes[$method])) {
			$this->routes[$method] = [];
		}

		// Apply middleware if it exists for the route
		foreach ($this->middleware as $route => $middlewareList) {
			// Check if the requested path starts with the middleware route
			if (strpos($path, $route) === 0) {
				foreach ($middlewareList as $middlewareData) {
					list($middlewareInstance, $middlewareMethod) = $middlewareData['middleware']; // Unpack instance and method
					$args = $middlewareData['args']; // Get the arguments

					if (method_exists($middlewareInstance, $middlewareMethod)) {
						// Call each middleware's method (e.g., handle) with the arguments
						call_user_func_array([$middlewareInstance, $middlewareMethod], $args);
					} else {
						echo "Method $middlewareMethod does not exist on middleware.";
					}
				}
			}
		}


		// Match the route and apply parameters if necessary
		foreach($this->routes[$method] as $route => $callback) {
			$routePattern = preg_replace('/{[a-zA-Z0-9]+}/', '([a-zA-Z0-9]+)', $route);

			if(preg_match("#^$routePattern$#", $path, $matches)) {
				array_shift($matches); // Remove the full match

				if(is_callable($callback)) {
					return call_user_func_array($callback, $matches);
				} else {
					echo "Callback is not callable.";
				}
			}
		}

		// If no route matches, display the error page using the ErrorController
		// Use a default error page if not set
		$this->errorCallback ? call_user_func($this->errorCallback) : print("404 - Page not found!");
	}

	// Helper function to format routes (remove trailing slashes)
	private function formatRoute($path) {
		return rtrim($path, '/');
	}
}
