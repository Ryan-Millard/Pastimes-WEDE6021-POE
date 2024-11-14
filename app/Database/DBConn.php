<?php

namespace App\Database;

require_once __DIR__ . './../../core/Functions/LoadEnv.php';

use App\Core\Functions\EnvLoader;

use Exception;

class Database {
	private static $host;
	private static $username;
	private static $password;
	private static $database;
	private static $sqlFilePath;

	private static $conn = null;

	public static function init($envPath = null) {
		// return if a connection already exists, no point in creating a new one
		if (self::$conn !== null) {
			return;
		}

		EnvLoader::load($envPath ?? __DIR__ . '/../../.env');
		self::$host = getenv('DB_HOST');
		self::$username = getenv('DB_USERNAME');
		self::$password = getenv('DB_PASSWORD');
		self::$database = getenv('DB_DATABASE');
		self::$sqlFilePath = __DIR__ . '/pastimes.sql';

		self::connect();
	}

	private static function connect() {
		try {
			self::$conn = new \mysqli(self::$host, self::$username, self::$password, self::$database);

			if (self::$conn->connect_error) {
				die("Connection failed: " . self::$conn->connect_error);
			}
		} catch (\Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}

	public static function createDatabaseIfNotExists() {
		// Create a temporary connection without selecting a specific database
		$tempConn = new \mysqli(self::$host, self::$username, self::$password);

		if ($tempConn->connect_error) {
			die("Connection failed: " . $tempConn->connect_error);
		}

		// Check if the database already exists
		$checkDBQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . self::$database . "'";
		$dbExists = $tempConn->query($checkDBQuery);

		if ($dbExists && $dbExists->num_rows > 0) {
			echo "Database `" . self::$database . "` already exists, skipping initial loading.\n\n";
		} else {
			// If the database doesn't exist, create it
			$createDBQuery = "CREATE DATABASE IF NOT EXISTS `" . self::$database . "`";
			if ($tempConn->query($createDBQuery) === TRUE) {
				echo "Database `" . self::$database . "` created successfully.\n\n";
				self::loadSqlDump($tempConn); // Load the SQL dump only after creating the database
			} else {
				die("Error creating database: " . $tempConn->error);
			}
		}

		$tempConn->close();
	}

	private static function loadSqlDump($connection) {
		// Check if the SQL file exists
		if (file_exists(self::$sqlFilePath)) {
			$sql = file_get_contents(self::$sqlFilePath);
			$queries = explode(';', $sql); // Split into individual queries

			foreach ($queries as $query) {
				$query = trim($query);
				if (!empty($query)) {
					if ($connection->query($query) === FALSE) {
						echo "Error executing query: " . $connection->error . "\n";
					}
				}
			}

			echo "SQL dump loaded successfully into `" . self::$database . "`.\n\n";
		} else {
			die("SQL dump file not found at: " . self::$sqlFilePath);
		}
	}

	public static function close() {
		if (self::$conn) {
			self::$conn->close();
			self::$conn = null;
			echo "Connection closed<br />";
		}
	}

	// This method provides access to the connection object
	public static function getConnection() {
		if (!self::$conn) {
			throw new Exception("Database connection not established.");
		}
		return self::$conn;
	}
}
