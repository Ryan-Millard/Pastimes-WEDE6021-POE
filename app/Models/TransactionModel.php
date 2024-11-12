<?php

namespace App\Models;

use App\Models\Model;

class TransactionModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Transactions';
		$this->tablePrimaryKey = 'transaction_id';
	}

	// Function to generate the reference number
	protected function generateReferenceNumber($transaction_id) {
		return 'REF-' . date('Y') . '-' . str_pad($transaction_id, 6, '0', STR_PAD_LEFT) . '-' . session_id();
	}

	public function insert($data) {
		// Generate the reference number first, based on the transaction ID
		$transaction_id = isset($data['transaction_id']) ? $data['transaction_id'] : 0; // Default to 0 if not set
		$referenceNumber = $this->generateReferenceNumber($transaction_id);  // Generate reference number based on ID

		// Include the reference number in the data to be inserted
		$data['reference_number'] = $referenceNumber;

		// Prepare the insert query to insert the data without the reference number first
		$columns = implode(", ", array_keys($data));
		$placeholders = implode(", ", array_fill(0, count($data), '?'));
		$types = $this->getParamTypes($data);

		// Prepare the insert statement
		$stmt = $this->conn->prepare("INSERT INTO $this->tableName ($columns) VALUES ($placeholders)");

		if(!$stmt)
			throw new Exception("Error preparing statement: " . $this->conn->error);

		// Bind the data to be inserted dynamically
		$stmt->bind_param($types, ...array_values($data));

		// Try to execute the insert statement
		try {
			if(!$stmt->execute())
				throw new Exception("Error executing query: " . $stmt->error);

			// Get the inserted transaction_id (auto-incremented ID)
			$transaction_id = $stmt->insert_id;

			// Now generate the reference number using the transaction_id
			$referenceNumber = $this->generateReferenceNumber($transaction_id);

			// Update the record with the generated reference number
			$updateData = ['reference_number' => $referenceNumber];
			$this->update($transaction_id, $updateData); // Update the record with reference number

			return $transaction_id; // Return the transaction ID
		} catch(Exception $e) {
			echo $e->getMessage();
			return false; // Return false if the insert fails
		}
	}
}
