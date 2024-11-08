<h2>Welcome to the Dashboard<?= $_SESSION['user']['username'] ? ', ' . $_SESSION['user']['username'] : ''  ?>!</h2>

<?php require __DIR__ . '/shared/banner.php'; ?>

<?php if (isset($userType) && $userType === 'buyer'): ?>
	<?php require __DIR__ . '/product_list.php'; ?>
<?php elseif (isset($userType) && $userType === 'seller'): ?>
	<?php require __DIR__ . '/new_listing.php'; ?>
	<?php require __DIR__ . '/product_list.php'; ?>
<?php endif; ?>


