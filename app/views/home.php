<link rel="stylesheet" href="css/home.css">

<div class="container">
	<div class="centered-text">
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
	</div>

	<?php require __DIR__ . '/shared/banner.php'; ?>

    <p>
        At <strong>Pastimes</strong>, we think that environmental sustainability should never be sacrificed for style. Using our platform,
         you can easily update your wardrobe and give pre-owned goods a new lease on life by buying and selling high-quality used apparel.
         We're here to help your fashion journey, whether you're looking for one-of-a-kind items to show off your distinctive style or 
        are trying to declutter and make some extra money. Discover the delight of buying sustainably by becoming a part of our community
         of conscientious shoppers!
    </p>
</div>

<style>
.centered-text {
text-align: center;
}
</style>
