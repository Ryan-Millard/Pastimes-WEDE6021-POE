<div class="chat-header">
    <h2><?= htmlspecialchars($otherUser['first_name'] . ' ' . $otherUser['last_name']) ?></h2>
    <p>@<?= htmlspecialchars($otherUser['username']) ?></p>
</div>

<div class="chat-container">
    <?php foreach ($conversation as $message): ?>
        <div class="message <?= $message['sender_id'] == $currentUserId ? 'sent' : 'received' ?>">
            <p><?= htmlspecialchars($message['message']) ?></p>
            <div class="message-info">
                <span><?= $message['sent_at'] ?></span>
                <?php if ($message['seen']): ?>
                    <span> | Seen at: <?= $message['seen_at'] ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<form action="/pastimes/messages/send" method="POST" class="message-form">
	<input type="hidden" name="receiver_id" value="<?= $otherUser['user_id'] ?>">
	<input type="hidden" name="sender_id" value="<?= $currentUserId ?>">
	<textarea name="message" placeholder="Type your message..." required></textarea>
	<button type="submit">Send</button>
</form>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #f4f4f9;
        padding: 20px;
    }

    .chat-header {
        text-align: center;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 10px 0;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .chat-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .chat-header p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #666;
    }

    .chat-container {
        width: 100%;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-height: 500px;
        overflow-y: auto;
    }

    .chat-container::-webkit-scrollbar {
        width: 8px;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    .message {
        padding: 12px 18px;
        margin-bottom: 10px;
        border-radius: 8px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .sent {
        background-color: #daf8e3;
        align-self: flex-end;
        text-align: right;
        margin-left: auto;
    }

    .received {
        background-color: #f1f1f1;
        align-self: flex-start;
        margin-right: auto;
    }

    .message-info {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }

    .message-form {
        display: flex;
        justify-content: space-between;
        align-items: bottom;
        gap: 10px;
        margin-top: 20px;
    }

    .message-form textarea {
        flex-grow: 1;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
		min-height: 50px;
        background-color: #f9f9f9;
		width: 90%;
    }

    .message-form button {
        padding: 12px 20px;
        border-radius: 5px;
        background-color: #4caf50;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .message-form button:hover {
        background-color: #45a049;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        .chat-container {
            padding: 15px;
        }

        .message-form textarea {
            min-height: 40px;
            font-size: 12px;
        }

        .message-form button {
            padding: 10px 15px;
            font-size: 14px;
        }
    }
</style>

