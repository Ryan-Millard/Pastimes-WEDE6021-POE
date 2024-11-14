<?php

namespace App\Seeders;

require_once __DIR__ . '/../Database/DBConn.php';
use App\Database\Database;

abstract class Seeder {
	protected $conn;
	protected string $tableName;
	protected string $tableStructure;
	protected string $columnTypes;
	protected string $seedFile;

	public function __construct() {
		Database::init(__DIR__ . '/../../.env');  // Initialize the database connection
		$this->conn = Database::getConnection();  // Get the `mysqli` connection object
	}

	public function clearTable() {
		$sql = "DROP TABLE IF EXISTS `{$this->tableName}`";
		if ($this->conn->query($sql) === FALSE) {
			throw new \Exception("Error dropping table: " . $this->conn->error);
		}
		echo "Table {$this->tableName} dropped successfully.\n";
	}

	public function createTable() {
		$sql = "CREATE OR REPLACE TABLE `{$this->tableName}` ({$this->tableStructure})";
		if ($this->conn->query($sql) === FALSE) {
			throw new \Exception("Error creating table: " . $this->conn->error);
		}
		echo "Table {$this->tableName} created successfully.\n";
	}

	public function seed() {
		$foreignKeys = $this->getForeignKeysConstraints();
		try {
			$this->conn->autocommit(false);  // Turn off autocommit
			$this->conn->begin_transaction();  // Start transaction

			$this->dropForeignKeys($foreignKeys);
			$this->clearTable();
			$this->createTable();

			$this->loadData();

			$this->conn->commit();  // Commit transaction on success
		} catch (\Exception $e) {
			$this->conn->rollback();  // Rollback transaction on failure
			throw $e;
		} finally {
			$this->conn->autocommit(true);  // Always re-enable autocommit
			$this->addForeignKeys($foreignKeys);
		}
	}

	protected function loadData(callable $callback = null) {
		echo "Callback: " . (is_null($callback) ? "None (null)" : "Exists (not null)") . "\n";

		$filePath = __DIR__ . '/data/' . $this->seedFile;
		if (!file_exists($filePath)) {
			throw new \Exception("Seed file not found: " . $filePath);
		}

		// handle txt files with csv format
		$handle = fopen($filePath, 'r');
		if ($handle) {
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

	public function getForeignKeysConstraints() {
		$sql = "
			SELECT
				TABLE_NAME,
				CONSTRAINT_NAME,
				COLUMN_NAME,
				REFERENCED_COLUMN_NAME
			FROM
				information_schema.KEY_COLUMN_USAGE
			WHERE
				REFERENCED_TABLE_NAME = '{$this->tableName}'
				AND TABLE_SCHEMA = 'pastimes';";

		$result = $this->conn->query($sql);
		if ($result === FALSE) {
			throw new \Exception("Error selecting foreign keys: " . $this->conn->error);
		}

		// Initialize an array to hold foreign key constraints
		$foreignKeys = [];
		while($row = $result->fetch_assoc()) {
			$foreignKeys[] = [
				'table' => $row['TABLE_NAME'],
				'constraint' => $row['CONSTRAINT_NAME'],
				'column' => $row['COLUMN_NAME'],
				'referencedColumn' => $row['REFERENCED_COLUMN_NAME']
			];
		}

		return $foreignKeys; // Return the array of foreign key constraints
	}


	public function dropForeignKeys($foreignKeys) {
		foreach($foreignKeys as $foreignKey) {
			// Add the SQL to drop foreign key constraints
			$sql = "ALTER TABLE `{$foreignKey['table']}` DROP FOREIGN KEY `{$foreignKey['constraint']}`"; // Adjust for each FK constraint
			// Execute the query using $this->conn
			if($this->conn->query($sql) === FALSE) {
				throw new \Exception("Error dropping foreign key on '{$foreignKey['table']}': " . $this->conn->error);
			}
		}
		echo "Foreign keys dropped successfully.\n";
	}

	public function addForeignKeys($foreignKeys) {
		foreach($foreignKeys as $foreignKey) {
			// Add the SQL to re-add foreign key constraints
			$sql = "ALTER TABLE `{$foreignKey['table']}`
						ADD CONSTRAINT `{$foreignKey['constraint']}`
						FOREIGN KEY (`{$foreignKey['column']}`)
						REFERENCES `{$this->tableName}`(`{$foreignKey['referencedColumn']}`)"; // Adjusted column references

			// Execute the query using $this->conn
			if ($this->conn->query($sql) === FALSE) {
				throw new \Exception("Error adding foreign key on '{$foreignKey['table']}': " . $this->conn->error);
			}
		}
		echo "Foreign keys added successfully.\n";
	}

}
