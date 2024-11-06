<h2>Welcome to the Dashboard<?= $_SESSION['user']['username'] ? ', ' . $_SESSION['user']['username'] : ''  ?>!</h2>

<?php require __DIR__ . '/shared/banner.php'; ?>

<?php require __DIR__ . '/product_list.php'; ?>
