<?php

namespace App\Models;

require_once __DIR__ . '/../Database/DBConn.php';

use App\Database\Database;
use Exception;

abstract class Model
{
	protected $conn;
	protected $tableName;

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

		if(!$stmt->execute())
			throw new Exception("Error executing query: " . $stmt->error);

		return $stmt->insert_id; // Return the inserted ID (Primary Key)
	}

	// Update an existing record by ID
	// id is the identifier (Primary Key)
	// data is associative [], key => value is column => entry
	public function update($id, $data)
	{
		$fields = '';	// contains column name and ? (placeholder for entry)
		foreach($data as $key => $value)
			$fields .= "$key = ?, ";	// append to fields
		$fields = rtrim($fields, ', ');	// remove the last comma
		// get the types of each column, and make sure id included
		$types = $this->getParamTypes($data) . 'i';  // Add 'i' for the integer `id`

		// prepare SQL statement
		$stmt = $this->conn->prepare("UPDATE $this->tableName SET $fields WHERE id = ?");

		if(!$stmt)
			throw new Exception("Error preparing statement: " . $this->conn->error);

		$data['id'] = $id;  // Add the ID to the data for binding
		// replace ? placeholder with actual entry
		$stmt->bind_param($types, ...array_values($data));

		if(!$stmt->execute())
			throw new Exception("Error executing query: " . $stmt->error);

		return $stmt->affected_rows; // Return the number of affected rows
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
	private function getParamTypes($data) {
		// Loop through data and accumulate type indicators
		$types = '';
		foreach($data as $value) {
			$types .= $this->getParamType($value);
		}

		return $types;
	}

	private function getParamType($value) {
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
}

