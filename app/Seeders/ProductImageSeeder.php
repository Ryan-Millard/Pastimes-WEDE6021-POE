<?php

namespace App\Seeders;

require_once __DIR__ . '/Seeder.php';

use App\Seeders\Seeder;

class ProductImageSeeder extends Seeder {
	protected $seedImageDir = __DIR__ . '/data/ProductImages/';

	public function __construct() {
		parent::__construct();
		$this->tableName = 'Product_Images';
		$this->tableStructure = '
			`product_image_id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
			`product_id` int(11) UNSIGNED NOT NULL,
			`product_image_url` varchar(255) NOT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
			FOREIGN KEY (`product_id`) REFERENCES `Products`(`product_id`) ON DELETE CASCADE';
		$this->columnTypes = 'iisss';
		$this->seedFile = 'productImageData.txt';
	}

	protected function loadData(?callable $callback = null) {
		echo "Callback: " . (is_null($callback) ? "None (null)" : "Exists (not null)") . "\n";

		$filePath = __DIR__ . '/data/' . $this->seedFile;
		if (!file_exists($filePath)) {
			throw new \Exception("Seed file not found: " . $filePath);
		}

		// handle txt files with csv format
		$handle = fopen($filePath, 'r');
		if($handle) {
			while (($line = fgets($handle)) !== false) {
				$data = array_map('trim', explode(',', $line));

				// Check each value in the data and replace 'null' string with NULL
				foreach ($data as $key => $value)
					if (strtolower($value) === 'null')
						$data[$key] = null;  // Modify the value in the $data array

				// Check if a valid callback was provided
				if(is_callable($callback))
					// Execute the callback and pass the task data
					$callback($data);

				$placeholders = implode(',', array_fill(0, count($data), '?'));

				$sql = "INSERT INTO {$this->tableName} VALUES ({$placeholders})";

				$stmt = $this->conn->prepare($sql);
				if ($stmt === false) {
					throw new \Exception("Error preparing statement: " . $this->conn->error);
				}

				$plainTextFileName = $data[2];

				// store file name as unique name
				$data[2] = uniqid() . '.' . pathinfo($data[2], PATHINFO_EXTENSION);

				$destinationPath = __DIR__ . '/../../public/images/products/' . $data[2];

				// Move the uploaded file to the destination directory
				if (!copy($this->seedImageDir . $plainTextFileName, $destinationPath)) {
					throw new \Exception('Error moving the uploaded file.');
				}

				$stmt->bind_param($this->columnTypes, ...$data);

				if ($stmt->execute() === false) {
					throw new \Exception("Error executing statement: " . $stmt->error);
				}
				$stmt->close();  // Close the statement to free resources
			}
			fclose($handle);
			echo "Data successfully seeded into {$this->tableName}.\n\n";
		} else {
			throw new \Exception("Error opening seed file: " . $filePath);
		}
	}

	public function clearTable() {
		$sql = "SELECT product_image_url from {$this->tableName}";

		$result = $this->conn->query($sql);

		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$imageName = $row['product_image_url'];
				$productionImageDir = __DIR__ . '/../../public/images/products/';
				$file = $productionImageDir . $imageName;

				if(file_exists($file)) {
					if(unlink($file)) {
						echo "File '$file' has been deleted.\n";
					}
					else {
						echo "Error deleting '$file'.\n";
					}
				}
				else {
					echo "File '$file' does not exist.\n";
				}
			}
		}

		return parent::clearTable();
	}
}
