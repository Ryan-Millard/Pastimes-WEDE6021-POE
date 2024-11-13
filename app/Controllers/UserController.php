<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . './../models/UserModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\UserModel;
use App\Models\Model;
use App\Controllers\Controller;

class UserController extends Controller {
	protected $userModel;
	public function __construct(
		UserModel $userModel,
		Model $sellerModel,
		Model $buyerModel,
		Model $adminModel,
	) {
		parent::__construct();

		$this->userModel = $userModel;
		$this->sellerModel = $sellerModel;
		$this->buyerModel = $buyerModel;
		$this->adminModel= $adminModel;
	}

	public function showLoginForm() {
		$this->render('login');
	}

	public function login() {
		if($_SERVER['REQUEST_METHOD'] != 'POST')
			$this->redirect('/pastimes/login');

		// Retrieve and sanitize input
		$username = htmlspecialchars(trim($_POST['username']));
		$password = htmlspecialchars(trim($_POST['password']));

		$unapprovedUsers = $this->userModel->getUnapprovedUsers();
		foreach($unapprovedUsers as $unapprovedUser) {
			// different username
			if($username !== $unapprovedUser['username'])
				continue;
			if(!password_verify($password, $unapprovedUser['password_hash']))
				continue;

			if($this->userModel->login($username, $password)) {
				$_SESSION['flash_message'] = 'Your account is still under review. Please be patient.';
				$this->redirect('/pastimes');
			}
		}

		// Attempt login
		$user = $this->userModel->login($username, $password);

		if($user) {
			$userId = $user['user_id'];

			// Fetch user roles
			$userRoles = [];
			if($this->buyerModel->getByUserId($userId))
				$userRoles[] = 'buyer';
			if($this->sellerModel->getByUserId($userId))
				$userRoles[] = 'seller';
			if($this->adminModel->getByUserId($userId))
				$userRoles[] = 'admin';
			$user['user_roles'] = $userRoles;

			// Start session and redirect to dashboard
			// session_start();
			$_SESSION['user'] = $user;

			// set the flash_message
			$_SESSION['flash_message'] = 'Logged in as ' . $_SESSION['user']['username'];

			$this->redirect('/pastimes/');
		} else {
			// Invalid credentials, return to login with an error
			$error = 'Invalid username or password';
			$this->setData(['error' => $error]);
			$this->render('login');
		}
	}

	public function showSignUpForm() {
		$this->render('signUp');
	}

	public function signUp() {
		if($_SERVER['REQUEST_METHOD'] != 'POST')
			$this->redirect('/pastimes/signup');

		// Sanitize and validate input data
		$username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8'); // Remove whitespace and prevent XSS
		$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitize email address
		$password = $_POST['password']; // leave password alone as spaces may be intentional, and it must be validated before hashing
		$first_name = htmlspecialchars(trim($_POST['first_name']), ENT_QUOTES, 'UTF-8'); // Sanitize to prevent XSS
		$last_name = htmlspecialchars(trim($_POST['last_name']), ENT_QUOTES, 'UTF-8'); // Sanitize to prevent XSS
		$bio = htmlspecialchars(trim($_POST['bio']), ENT_QUOTES, 'UTF-8'); // Sanitize to prevent XSS
		$phone_number = filter_var(trim($_POST['phone_number']), FILTER_SANITIZE_NUMBER_INT); // Remove anything other than digits and + sign

		// create an array of errors to display to the user
		// based on input validation, with removed null values
		// re-index the array to ensure it is sequentially indexed
		$errors = array_values(array_filter([
			$this->validateUsername($username),
			$this->validateEmail($email),
			$this->validatePassword($password),
			$this->validateFirstName($first_name),
			$this->validateLastName($last_name),
			$this->validateBio($bio),
			$this->validatePhoneNumber($phone_number),
		]));

		if(!empty($errors)) {
			$this->setData(['error' => $errors[0]]);
			$this->render('signUp');
			return;
		}

		$dataForInsert = [
			'username' => $username,
			'email' => $email,
			'password_hash' => password_hash($password, PASSWORD_DEFAULT),
			'first_name' => $first_name,
			'last_name' => $last_name,
			'bio' => $bio,
			'phone_number' => $phone_number
		];

		try {
			$this->userModel->insert($dataForInsert);
		} catch(\Exception $e) {
			echo "An error has occurred: " . $e->getMessage() . '<br />';
		}

		$_SESSION['flash_message'] = 'Your account has been created successfully and will be reviewed by an admin before you are allowed to login.';
		$_SESSION['user']['tempName'] = 'a Guest because your account is under review.';
		$this->redirect('/pastimes');
	}

	public function logout() {
		session_start();
		$_SESSION = array();

		$_SESSION['flash_message'] = 'You have been logged out successfully!';
		$this->redirect('/pastimes/login');
	}

	// Validate username
	public function validateUsername($username) {
		$username = htmlspecialchars(trim($username), ENT_QUOTES, 'UTF-8');
		$userNameTaken = (bool)$this->userModel->getByColumnValue('username', $username);
		if($userNameTaken)
			return "Username has already been taken. Please try another one.";
		if (empty($username) || !ctype_alnum($username)) {
			return "Username is required and must be alphanumeric.";
		} elseif (strlen($username) < 5 || strlen($username) > 20) {
			return "Username must be between 5 and 20 characters.";
		}
		return null;
	}

	// Validate email
	public function validateEmail($email) {
		$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return "Invalid email format.";
		}
		return null;
	}

	// Validate password
	public function validatePassword($password) {
		if (empty($password) || strlen($password) < 8 ||
			!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
			return "Password must be at least 8 characters long and include both letters and numbers.";
		}
		return null;
	}

	// Validate first name
	public function validateFirstName($firstName) {
		$firstName = htmlspecialchars(trim($firstName), ENT_QUOTES, 'UTF-8');
		if (empty($firstName) || !preg_match("/^[a-zA-Z]+$/", $firstName)) {
			return "First name is required and must contain only letters.";
		} elseif (strlen($firstName) > 50) {
			return "First name must not exceed 50 characters.";
		}
		return null;
	}

	// Validate last name
	public function validateLastName($lastName) {
		$lastName = htmlspecialchars(trim($lastName), ENT_QUOTES, 'UTF-8');
		if (empty($lastName) || !preg_match("/^[a-zA-Z]+$/", $lastName)) {
			return "Last name is required and must contain only letters.";
		} elseif (strlen($lastName) > 50) {
			return "Last name must not exceed 50 characters.";
		}
		return null;
	}

	// Validate bio
	public function validateBio($bio) {
		$bio = htmlspecialchars(trim($bio), ENT_QUOTES, 'UTF-8');
		if (!empty($bio) && strlen($bio) > 500) {
			return "Bio must not exceed 500 characters.";
		}
		return null;
	}

	// Validate phone number
	public function validatePhoneNumber($phoneNumber) {
		$phoneNumber = filter_var(trim($phoneNumber), FILTER_SANITIZE_NUMBER_INT);
		if(!empty($phoneNumber) && (strlen($phoneNumber) < 10 || strlen($phoneNumber) > 15)) {
			return "Phone number must be between 10 and 15 digits.";
		}
		return null;
	}
}
