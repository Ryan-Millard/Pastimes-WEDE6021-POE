<?php

namespace App\Controllers;

require_once __DIR__ . './../models/Model.php';
require_once __DIR__ . '/Controller.php';

use App\Models\Model;
use App\Controllers\Controller;

class MessageController extends Controller {
	protected $messageModel;
	protected $userModel;

	public function __construct(Model $messageModel = null, Model $userModel = null) {
		parent::__construct();

		$this->messageModel = $messageModel;
		$this->userModel = $userModel;
	}

	public function showAll() {
		$userId = (int)$_SESSION['user']['user_id'];
		$latestMessagesInConversation = $this->messageModel->getLatestMessagesByUserId($userId);

		if(!$latestMessagesInConversation) {
			$this->setData([
				'no_messages' => true,
			]);
			$this->render('message_list');
			return;
		}

		foreach ($latestMessagesInConversation as $key => $message) {
			$senderId = $message['sender_id'];
			$receiverId = $message['receiver_id'];

			// Check if the logged-in user is the sender or receiver and get the other user's name
			$otherUserId = $senderId;
			if ($senderId == $userId) {
				$otherUserId = $receiverId;
			}
			echo $otherUserId . '<br />';

			// Fetch the other user's name using getById
			$otherUser = $this->userModel->getById($otherUserId);

			// Add the other user's name to the message array
			$latestMessagesInConversation[$key]['other_user_name'] = $otherUser['username'];
			$latestMessagesInConversation[$key]['other_user_id'] = $otherUser['user_id'];
		}

		$this->setData([
			'messages' => $latestMessagesInConversation,
			'userId' => $userId,
		]);
		$this->render('message_list');
	}

	public function getConversation($externalUserId) {
		$currentUserId = (int)$_SESSION['user']['user_id'];
		$conversation = $this->messageModel->getConversationBetweenUsers($currentUserId, $externalUserId);
		$externalUser = $this->userModel->getById($externalUserId);

		foreach($conversation as $message) {
			if($message['receiver_id'] === $currentUserId)
				$this->messageModel->updateSeenAt($message['message_id']);
		}

		$this->setData([
			'conversation' =>$conversation,
			'currentUserId' => $currentUserId,
			'otherUser' => $externalUser,
		]);
		$this->render('single_conversation');
	}

	public function sendMessage() {
		[
			'sender_id' => $senderId,
			'receiver_id' => $receiverId,
			'message' => $message,
		] = $_POST;

		$back = fn() => $this->redirect('/pastimes/messages/' . $receiverId);

		if(!$message) {
			$back();
		}

		if((int)$senderId !== $_SESSION['user']['user_id']) {
			$back();
		}

		$dataForInsert = [
			'sender_id' => $senderId,
			'receiver_id' => $receiverId,
			'message' => $message,
		];
		$this->messageModel->insert($dataForInsert);

		$back();
	}
}

