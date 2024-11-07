<div class="message-container">
    <h1>Contacts</h1>
    <?php foreach($messages as $message): ?>
        <a href="/pastimes/messages/<?= htmlspecialchars($message['sender_id']); ?>">
            <div class="contact">
                <img src="https://via.placeholder.com/40" alt="contact1">
                <div class="entry-holder">
                    <div class="contact-name"><?= htmlspecialchars($message['other_user_name']); ?></div>

                    <?php
                        $messageColorClass = '';
                        if($userId === (int)$message['receiver_id'] && empty($message['seen_at']))
                            $messageColorClass = 'unread';
                    ?>
                    <div class="contact-last-message <?= htmlspecialchars($messageColorClass); ?>">
                        <?= htmlspecialchars($message['message']); ?>
                    </div>
                </div>
                <div class="contact-time"><?= $message['sent_at']; ?></div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<style>
.message-container {
    padding: 20px;
    overflow-y: auto;

	a {
		text-decoration: none;
	}
}

.message-container h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2rem;
    color: #333;
}

.contact {
    background-color: #fff;
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

.contact:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.contact img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.entry-holder {
    flex: 1;
    overflow: hidden;
}

.contact-name {
    font-weight: bold;
    color: #007BFF;
    font-size: 1.1rem;
}

.contact-last-message {
    color: #555;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.unread {
    color: red;
    font-weight: bold;
}

.contact-time {
    font-size: 0.8rem;
    color: #888;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .contact {
        flex-direction: column;
        align-items: flex-start;
    }

    .entry-holder {
        width: 100%;
        margin-top: 5px;
    }

    .contact img {
        width: 50px;
        height: 50px;
        margin-bottom: 10px;
    }
}
</style>

