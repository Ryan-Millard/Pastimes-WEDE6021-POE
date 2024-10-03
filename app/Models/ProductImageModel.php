<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class ProductImageModel extends Model {
	// Define the directory path to the images
	protected $imageDirectory = __DIR__ . '/../../public/images/products/';

	public function __construct() {
		parent::__construct();
		$this->tableName = 'Product_Images';
	}

	public function getAllDbEntries() {
		// different function name to distinguish between img file and entry
		return parent::getAll();
	}

	public function getAllImgFiles() {
		$images = scandir($this->imageDirectory); // Get all files in the directory
		// Filter the images to exclude '.' and '..'
		$images = array_values(array_diff($images, array('.', '..')));

		return $images;
	}

	public function getImageDirectory() {
		return $this->imageDirectory;
	}

	/**
	 * Function to get image by name
	 *
	 * @param string $imageName The name of the image file
	 * @return string|false The image if found, or false if not found
	 */
	public function getImageByName($imageName) {
		// Check if the file exists
		if (file_exists($this->imageDirectory . $imageName)) {
			return $imageName;
		}

		// Return false if the image does not exist
		return false;
	}
}
