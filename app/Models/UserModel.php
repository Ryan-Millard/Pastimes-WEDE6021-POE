<?php

namespace App\Models;

require_once __DIR__ . '/Model.php';

use App\Models\Model;

class UserModel extends Model {
	public function __construct() {
		parent::__construct();
		$this->tableName = 'Users';
	}

	public function login($username, $plainTextPassword) {
		$user = $this->getByColumnValue('username', $username);

		if($user && password_verify($plainTextPassword, $user['password_hash']))
			return $user;

		return false;
	}

	public function insert($data) {
		return parent::insert($data);
	}

	// Method to get users that haven't been approved
	public function getUnapprovedUsers() {
		try {
			$stmt = $this->conn->prepare("
				SELECT u.*
				FROM Users u
				LEFT JOIN Admins a ON a.user_id = u.user_id
				LEFT JOIN Buyers b ON b.user_id = u.user_id
				LEFT JOIN Sellers s ON s.user_id = u.user_id
				WHERE a.user_id IS NULL
				  AND b.user_id IS NULL
				  AND s.user_id IS NULL
			");

			if ($stmt === false) {
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}

			if (!$stmt->execute()) {
				throw new Exception("Error executing statement: " . $stmt->error);
			}

			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				return $result->fetch_all(MYSQLI_ASSOC); // Fetch data as associative array
			}

			return []; // Return empty array if no unapproved users found
		} catch (Exception $e) {
			echo $e->getMessage();
			return []; // Return empty array on exception
		}
	}
}
