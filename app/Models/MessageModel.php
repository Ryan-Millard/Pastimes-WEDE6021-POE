<?php

namespace App\Models;

use App\Models\Model; // Assuming Model class is in the same namespace

class MessageModel extends Model {
	public function __construct() {
		parent::__construct(); // Calls the parent constructor if defined
		$this->tableName = 'Messages'; // Set the table name
	}
	// Function to get the latest messages in all conversations involving the user
	public function getLatestMessagesByUserId($userId) {
		try {
			// Prepare the SQL query
			$query = "
				SELECT m.*
				FROM Messages m
				JOIN (
					SELECT 
						LEAST(sender_id, receiver_id) AS user1,
						GREATEST(sender_id, receiver_id) AS user2,
						MAX(sent_at) AS latest_sent_at
					FROM Messages
					WHERE sender_id = ? OR receiver_id = ?
					GROUP BY user1, user2
				) latest_messages
					ON (LEAST(m.sender_id, m.receiver_id) = latest_messages.user1
						AND GREATEST(m.sender_id, m.receiver_id) = latest_messages.user2
						AND m.sent_at = latest_messages.latest_sent_at)
				ORDER BY m.sent_at DESC
			";

			// Prepare the statement
			$stmt = $this->conn->prepare($query);
			if ($stmt === false) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			// Bind the userId for both sender_id and receiver_id
			$stmt->bind_param('ii', $userId, $userId);

			// Execute the query
			if (!$stmt->execute()) {
				throw new Exception("Error executing query: " . $stmt->error);
			}

			// Get the result
			$result = $stmt->get_result();

			// Return the fetched messages as an associative array
			if ($result->num_rows > 0) {
				return $result->fetch_all(MYSQLI_ASSOC);
			}

			return [];  // Return an empty array if no results are found
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return [];  // Return an empty array in case of error
	}

	// Function to get the conversation between two users based on their IDs
	public function getConversationBetweenUsers($userId1, $userId2) {
		try {
			// Prepare the SQL query
			$query = "
				SELECT *
				FROM Messages
				WHERE (sender_id = ? AND receiver_id = ?)
				   OR (sender_id = ? AND receiver_id = ?)
				ORDER BY sent_at ASC
			";

			// Prepare the statement
			$stmt = $this->conn->prepare($query);
			if ($stmt === false) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			// Bind the user IDs for both sender_id and receiver_id in both directions
			$stmt->bind_param('iiii', $userId1, $userId2, $userId2, $userId1);

			// Execute the query
			if (!$stmt->execute()) {
				throw new Exception("Error executing query: " . $stmt->error);
			}

			// Get the result
			$result = $stmt->get_result();

			// Return the fetched messages as an associative array
			if ($result->num_rows > 0) {
				return $result->fetch_all(MYSQLI_ASSOC);
			}

			return [];  // Return an empty array if no messages are found
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return [];  // Return an empty array in case of error
	}
}
