<?php

namespace App\Core\Functions;

use RuntimeException;

class EnvLoader {
	// function to load the .env file into $_ENV
	static function load(string $filePath = __DIR__ . '/../../.env') {
		// Check if the .env file exists
		if (!file_exists($filePath)) {
			throw new RuntimeException("ENV file not found: " . $filePath);
		}

		$lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Read lines from the .env file
		$loadedVarsCount = 0; // Counter for loaded variables

		foreach ($lines as $line) {
			// Ignore comments
			if (strpos(trim($line), '#') === 0) {
				continue;
			}

			// Parse the line into key-value pairs
			list($key, $value) = explode('=', $line, 2);
			$key = trim($key);
			$value = trim($value);

			// Validate key and value
			if (!empty($key)) {
				putenv("$key=$value"); // Set environment variable
				$_ENV[$key] = $value; // Populate ENV for global access
				$loadedVarsCount++; // Increment counter
			}
		}

		return $loadedVarsCount; // Return number of loaded variables
	}
}
