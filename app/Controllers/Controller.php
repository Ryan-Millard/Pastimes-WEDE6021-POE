<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';

use App\Models\Model;

abstract class Controller
{
	protected $model;
	protected $viewPath = __DIR__ . '/../views/';
	protected $data = [];

	protected function __construct(Model $model = null) {
		$this->model = $model;
	}

	/**
	 * Set data for the view
	 *
	 * @param array $data
	 */
	protected function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Set path to the view
	 *
	 * @param string $viewPath
	 */
	protected function setViewPath(string $viewPath)
	{
		$this->viewPath = $viewPath;
	}

	/**
	 * Render a view file
	 *
	 * @param string[] $viewNames
	 */
	protected function render(...$viewNames)
	{
		foreach ($viewNames as $viewName) {
			$viewFile = $this->viewPath . $viewName . '.php';

			if (!file_exists($viewFile)) {
				throw new \Exception("View file not found: " . $viewFile);
			}

			// Use flash_message popup
			if (!empty($_SESSION['flash_message'])) {
				require __DIR__ . '/../views/shared/flash_message.php';
			}

			// Extract data to variables for use in the view
			extract($this->data);
			require $viewFile;
		}
	}

	/**
	 * Redirect to a different URL
	 *
	 * @param string $url
	 */
	protected function redirect($url)
	{
		header("Location: " . $url);
		exit();
	}
}

