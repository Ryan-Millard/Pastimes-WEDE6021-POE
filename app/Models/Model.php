<?php

namespace App\Models;

require_once __DIR__ . '/../Database/DBConn.php';

use App\Database\Database;
use Exception;

abstract class Model
{
	protected $conn;
	protected $tableName;
	protected $tablePrimaryKey;

	public function __construct()
	{
		Database::init();  // Initialize the database connection
		$this->conn = Database::getConnection();  // Get the `mysqli` connection object
	}

	// Fetch all records from the table
	public function getAll()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM $this->tableName");

			if($stmt === false)
				throw new Exception("Error preparing statement: " . $this->conn->error);

			if(!$stmt->execute())
				throw new Exception("Error executing statement: " . $stmt->error);

			$result = $stmt->get_result();

			if($result->num_rows > 0)
				return $result->fetch_all(MYSQLI_ASSOC); // Fetch data as associative array
		} catch(Exception $e) {
			echo $e->getMessage();
		}

		return [];
	}

	// Public function to get a single row by column value
	public function getByColumnValue($columnName, $value)
	{
		return $this->fetchResultsByColumn($columnName, $value, false);  // Fetch a single row
	}

	// Public function to get all rows by column value
	public function getAllByColumnValue($columnName, $value)
	{
		return $this->fetchResultsByColumn($columnName, $value, true);  // Fetch all rows
	}

	// Delete records by column value
	public function deleteByColumnValue($columnName, $value) {
		try {
			// Prepare the SQL statement
			$stmt = $this->conn->prepare("DELETE FROM {$this->tableName} WHERE {$columnName} = ?");

			if (!$stmt) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			// Determine the parameter type
			$type = $this->getParamType($value);
			// Bind the value
			$stmt->bind_param($type, $value);

			if (!$stmt->execute()) {
				throw new Exception("Error executing query: " . $stmt->error);
			}

			return $stmt->affected_rows; // Return the number of affected rows
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return 0; // Return 0 if no rows were affected
	}

	// Delete records by multiple column values (for composite PK)
	public function deleteByColumnsValues($conditions) {
		try {
			// Prepare the WHERE clause with multiple conditions (for composite PK)
			$columns = implode(' AND ', array_map(function($key) {
				return "$key = ?";
			}, array_keys($conditions)));

			// Prepare the SQL statement
			$stmt = $this->conn->prepare("DELETE FROM {$this->tableName} WHERE {$columns}");

			if (!$stmt) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			// Get the parameter types for the provided conditions
			$types = $this->getParamTypes($conditions);
			// Bind the values dynamically based on the conditions array
			$stmt->bind_param($types, ...array_values($conditions));

			if (!$stmt->execute()) {
				throw new Exception("Error executing query: " . $stmt->error);
			}

			return $stmt->affected_rows; // Return the number of affected rows
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return 0; // Return 0 if no rows were affected
	}

	// Insert a new record into the table
	// data is associative [], key => value is column => entry
	public function insert($data) {
		// create a comma-sparated string of columns
		$columns = implode(", ", array_keys($data));
		// create a placeholder in the db query with ? to be replaced with actual values later
		$placeholders = implode(", ", array_fill(0, count($data), '?'));
		// get the parameter types as a string - i for integer, s for string, etc
		$types = $this->getParamTypes($data);

		// prepate SQL statement
		$stmt = $this->conn->prepare("INSERT INTO $this->tableName ($columns) VALUES ($placeholders)");

		if(!$stmt)
			throw new Exception("Error preparing statement: " . $this->conn->error);

		// Bind the data to be inserted dynamically
		$stmt->bind_param($types, ...array_values($data));

		try {
			if(!$stmt->execute())
				throw new Exception("Error executing query: " . $stmt->error);
		} catch(Exception $e) {
			echo $e->getMessage();
			return false;
		}

		return $stmt->insert_id; // Return the inserted ID (Primary Key)
	}

	// Update an existing record by ID
	// id is the identifier (Primary Key)
	// data is associative [], key => value is column => entry
	public function update($id, $data)
	{
		$fields = ''; // contains column name and ? (placeholder for entry)
		foreach($data as $key => $value)
			$fields .= "$key = ?, "; // append to fields
		$fields = rtrim($fields, ', '); // remove the last comma

		// get the types of each column, and make sure id included
		$types = $this->getParamTypes($data) . 'i';  // Add 'i' for the integer `id`

		// prepare SQL statement for updating the record
		$stmt = $this->conn->prepare("UPDATE $this->tableName SET $fields WHERE $this->tablePrimaryKey = ?");

		if(!$stmt)
			throw new Exception("Error preparing statement: " . $this->conn->error);

		$data['id'] = $id;  // Add the ID to the data for binding
		// bind the parameters (including ID)
		$stmt->bind_param($types, ...array_values($data));

		// execute the update
		if(!$stmt->execute())
			throw new Exception("Error executing query: " . $stmt->error);

		// // Check if any rows were affected
		// if ($stmt->affected_rows <= 0) {
			// throw new Exception("No rows affected or record not found.");
		// }

		// After successful update, retrieve the updated record
		$stmt->close(); // close the update statement

		// Prepare a new statement to select the updated record
		$selectStmt = $this->conn->prepare("SELECT * FROM $this->tableName WHERE $this->tablePrimaryKey = ?");
		if (!$selectStmt)
			throw new Exception("Error preparing select statement: " . $this->conn->error);

		// Bind the ID parameter
		$selectStmt->bind_param('i', $id);

		// Execute the select query
		if (!$selectStmt->execute())
			throw new Exception("Error executing select query: " . $selectStmt->error);

		// Get the result
		$result = $selectStmt->get_result();
		$updatedRecord = $result->fetch_assoc(); // Fetch the updated record as an associative array

		$selectStmt->close(); // Close the select statement

		return $updatedRecord; // Return the updated record
	}

	// Delete a record by ID
	// id is the identifier of record (Primary Key)
	public function delete($id)
	{
		// prepare SQL statement
		$stmt = $this->conn->prepare("DELETE FROM $this->tableName WHERE id = ?");
		// replace placeholder with id
		$stmt->bind_param('i', $id);

		if(!$stmt->execute())
			throw new Exception("Error executing query: " . $stmt->error);

		return $stmt->affected_rows;
	}

	public function getCount()
	{
		try {
			// Prepare the SQL statement
			$stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM $this->tableName");

			if (!$stmt) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			if (!$stmt->execute()) {
				throw new Exception("Error executing query: " . $stmt->error);
			}

			// Fetch the result
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();

			return $row['total']; // Return the count of entries
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return 0; // Return 0 if there's an error
	}


	// Helper function to get parameter types for bind_param based on data types
	// data is associative [], key => value is column => entry
	protected function getParamTypes($data) {
		// Loop through data and accumulate type indicators
		$types = '';
		foreach($data as $value) {
			$types .= $this->getParamType($value);
		}

		return $types;
	}

	protected function getParamType($value) {
		// Array to map PHP type to corresponding type indicator
		$typeMap = [
			'integer' => 'i',
			'double' => 'd',
			'string' => 's',
		];

		$type = gettype($value);
		return $typeMap[$type] ?? 'b'; // Fallback to 'b' (blob type) for unrecognized types
	}

	// Private helper function that handles the common logic
	private function fetchResultsByColumn($columnName, $value, $fetchAll = false)
	{
		try {
			if (empty($this->tableName))
				throw new Exception("Table name is not defined.");

			$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE {$columnName} = ?");

			if (!$stmt)
				throw new Exception("Error preparing statement: " . $this->conn->error);

			$type = $this->getParamType($value);
			$stmt->bind_param($type, $value);

			if (!$stmt->execute())
				throw new Exception("Error executing statement: " . $stmt->error);

			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				// Fetch all rows or just a single row based on the flag
				return $fetchAll ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $fetchAll ? [] : null;  // Return an empty array or null based on the fetch type
	}

	// Public function to get a single row by multiple column values
	public function getByMultipleColumnValues($conditions)
	{
		return $this->fetchResultsByMultipleColumns($conditions, false); // Fetch a single row
	}

	// Public function to get multiple rows by multiple column values
	public function getAllByMultipleColumnValues($conditions)
	{
		return $this->fetchResultsByMultipleColumns($conditions, true); // Fetch all rows
	}

	// Private helper function to fetch results by multiple columns
	private function fetchResultsByMultipleColumns($conditions, $fetchAll = false)
	{
		try {
			if (empty($this->tableName)) {
				throw new Exception("Table name is not defined.");
			}

			// Prepare the WHERE clause with multiple conditions
			$columns = implode(' AND ', array_map(function($key) {
				return "$key = ?";
			}, array_keys($conditions)));

			// Prepare the SQL statement
			$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE {$columns}");

			if (!$stmt) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			// Get the parameter types
			$types = $this->getParamTypes($conditions);
			// Bind the values dynamically
			$stmt->bind_param($types, ...array_values($conditions));

			if (!$stmt->execute()) {
				throw new Exception("Error executing statement: " . $stmt->error);
			}

			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				// Fetch all rows or just a single row based on the flag
				return $fetchAll ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $fetchAll ? [] : null; // Return an empty array or null based on the fetch type
	}

	public function getById($id) {
		return $this->getByColumnValue($this->tablePrimaryKey, $id);
	}
}
