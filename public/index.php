<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pastimes</title>
</head>
<body>
	<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		session_start();

		require_once '../app/views/shared/header.php';
	?>

	<main>
		<?php require_once '../app/app.php'; ?>
	</main>

	<?php require_once '../app/views/shared/footer.php'; ?>
</body>
</html>

