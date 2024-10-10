<h1 class="admin-title">Admin Panel</h1>

<h3 class="pending-title">Users Pending Approval:</h3>
<ul class="user-list">
    <?php if(!empty($users)): ?>
        <?php foreach($users as $user): ?>
            <li class="user-item">
                <a class="user-link" href="/pastimes/admin/users/<?php echo htmlspecialchars($user['user_id']); ?>">
                    <?php echo htmlspecialchars($user['username']); ?> - 
                </a>
                <span class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="no-users">No users found.</li>
    <?php endif; ?>
</ul>

<style>
/* Admin Panel Title */
.admin-title {
    font-size: 2em;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

/* Pending Users Title */
.pending-title {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #555;
}

/* User List */
.user-list {
    list-style-type: none;
    padding: 0;
}

/* Individual User Item */
.user-item {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

/* User Link */
.user-link {
    color: #007bff;
    text-decoration: none;
}

/* Hover Effect for Links */
.user-link:hover {
    text-decoration: underline;
}

/* User Name */
.user-name {
    color: #555;
}

/* No Users Message */
.no-users {
    font-style: italic;
    color: #777;
    text-align: center;
    padding: 20px;
}

</style>
