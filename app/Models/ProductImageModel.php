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

	/**
	 * Insert image metadata into the database and save the image file on the server.
	 *
	 * @param array $fileData The uploaded image file from $_FILES.
	 * @param int $productId The associated product ID.
	 * @return int|false The ID of the inserted image, or false on failure.
	 */
	public function insertImage($fileData, $productId) {
		try {
			// Check for file upload errors
			if ($fileData['error'] !== UPLOAD_ERR_OK) {
				throw new \Exception('File upload error: ' . $fileData['error']);
			}

			// Generate a unique file name to avoid conflicts
			$fileName = uniqid() . '.' . pathinfo($fileData['name'], PATHINFO_EXTENSION);

			// Define the destination path for the image file
			$destinationPath = $this->imageDirectory . $fileName;

			// Move the uploaded file to the destination directory
			if (!move_uploaded_file($fileData['tmp_name'], $destinationPath)) {
				throw new \Exception('Error moving the uploaded file.');
			}

			// Prepare the image metadata for database insertion
			$data = [
				'product_id' => $productId,
				'product_image_url' => $fileName,  // Store the path where the image is saved
			];

			// Insert the image metadata into the database
			return $this->insert($data);  // Call the `insert` function from the parent Model
		} catch (\Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}
}
