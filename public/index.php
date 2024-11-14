<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pastimes</title>
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<header>
	<?php
		require_once '../app/views/shared/header.php';
	?>
	</header>

	<main>
		<?php require_once '../app/app.php'; ?>
	</main>

	<?php require_once '../app/views/shared/footer.php'; ?>
</body>
</html>

