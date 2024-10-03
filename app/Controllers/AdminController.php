<?php

namespace App\Controllers;

require_once __DIR__ . './../models/UserModel.php';
require_once __DIR__ . './../models/AdminModel.php';
require_once __DIR__ . './../models/BuyerModel.php';
require_once __DIR__ . './../models/SellerModel.php';
require_once __DIR__ . '/Controller.php';

use App\Models\UserModel;
use App\Models\AdminModel;
use App\Models\BuyerModel;
use App\Models\SellerModel;

class AdminController extends Controller {
	protected $userModel;
	protected $adminModel;
	protected $buyerModel;
	protected $sellerModel;

	public function __construct(
		AdminModel $adminModel = null,
		UserModel $userModel = null,
		BuyerModel $buyerModel = null,
		SellerModel $sellerModel = null
	) {
		$this->adminModel = $adminModel;
		$this->userModel = $userModel;
		$this->buyerModel = $buyerModel;
		$this->sellerModel = $sellerModel;
	}

	public function showDashboard() {
		$unapprovedUsers = $this->userModel->getUnapprovedUsers();
		$this->setData(['users' => $unapprovedUsers]);
		$this->render('adminDashboard');
	}

	public function showUserById($id) {
		$user = $this->userModel->getByColumnValue('user_id', $id);
		if (empty($user)) {
			$this->setFlashMessage('That user could not be found');
			return $this->redirect('/pastimes/admin');
		}

		$this->setData(['user' => $user]);
		$this->render('single_user');
	}

	public function moderateUser($id) {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return $this->redirect('/pastimes/admin/users/' . $id);
		}

		if ($_POST['approve'] === "0") {
			$this->userModel->deleteByColumnValue('user_id', $id);
			$this->setFlashMessage('User has been deleted successfully.');
			return $this->redirect('/pastimes/admin');
		}

		if ($_POST['approve'] !== "1") {
			$this->setFlashMessage('An error has occurred. Please try again.');
			return $this->redirect('/pastimes/admin/users/' . $id);
		}

		$this->registerUser($id, $_POST['role']);
	}

	private function registerUser($id, $role) {
		$dataForInsert = ['user_id' => $id];

		switch ($role) {
		case "seller":
			$this->checkDuplicateAndInsert($this->sellerModel, $dataForInsert, 'seller', $id);
			break;
		case "buyer":
			$this->checkDuplicateAndInsert($this->buyerModel, $dataForInsert, 'buyer', $id);
			break;
		case "admin":
			$this->checkDuplicateAndInsert($this->adminModel, $dataForInsert, 'admin', $id);
			break;
		default:
			$this->setFlashMessage('An error has occurred. Please try again.');
			return $this->redirect('/pastimes/admin/users/' . $id);
		}
	}

	private function checkDuplicateAndInsert($model, $data, $role, $id) {
		if ($model->getByColumnValue($role . '_id', $id)) {
			$this->setFlashMessage("That user has already been registered as a $role.");
		} else {
			$model->insert($data);
			$this->setFlashMessage("That user has been successfully registered as a $role.");
		}
		return $this->redirect('/pastimes/admin');
	}

	private function setFlashMessage($message) {
		$_SESSION['flash_message'] = $message;
	}
}

