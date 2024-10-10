<h2>Welcome to the Dashboard<?= $_SESSION['user']['username'] ? ', ' . $_SESSION['user']['username'] : ''  ?>!</h2>

<?php require __DIR__ . '/shared/banner.php'; ?>

<p>This is the dashboard, which will be implemented in the final part of this POE.</p>
