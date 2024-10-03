<h1>Welcome to Pastimes!</h1>
<h2>You are logged in as 
	<?php
		if(!empty($_SESSION['user']['username']))
			echo $_SESSION['user']['username'];
		elseif(!empty($_SESSION['user']['tempName']))
			echo $_SESSION['user']['tempName'];
		else
			echo 'a Guest';
	?>
</h2>
