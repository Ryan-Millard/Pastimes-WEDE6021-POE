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

	private static $conn = null;

	public static function init($envPath = null) {
		// return if a connection already exist, no point creating a new one
		if(self::$conn !== null) {
			return;
		}

		EnvLoader::load($envPath ?? __DIR__ . '/../../.env');
		self::$host = getenv('DB_HOST');
		self::$username = getenv('DB_USERNAME');
		self::$password = getenv('DB_PASSWORD');
		self::$database = getenv('DB_DATABASE');

		self::connect();
	}

	private static function connect() {
		try {
			self::$conn = new \mysqli(self::$host, self::$username, self::$password, self::$database);

			if(self::$conn->connect_error)
				die("Connection failed: " . self::$conn->connect_error);
		} catch(\Exception $e) {
			echo $e->getMessage(). "\n";
		}
	}

	public static function close() {
		if(self::$conn) {
			self::$conn->close();
			self::$conn = null;
			echo "Connection closed<br />";
		}
	}

	// This method provides access to the connection object
	public static function getConnection() {
		if(!self::$conn) {
			throw new Exception("Database connection not established.");
		}
		return self::$conn;
	}
}
?>

