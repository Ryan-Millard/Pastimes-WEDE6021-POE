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

	<p class="introductory-paragraph">
		At <strong class="strong">Pastimes</strong>, we think that environmental sustainability should never be sacrificed for style. Using our platform,
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

.introductory-paragraph {
    font-size: 1.2em; /* Larger font for better readability */
    line-height: 1.6; /* Increased line height for better text spacing */
    color: #333; /* Darker color for better contrast */
    margin: 20px 0; /* Adding space above and below the paragraph */
    padding: 10px 15px; /* Adding padding for some space around the text */
    background-color: #f9f9f9; /* Light background to make the text stand out */
    border-left: 4px solid #007bff; /* Add a left border to give a subtle accent */
    border-radius: 5px; /* Slight rounding of the edges */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adding a subtle shadow for depth */
}

.introductory-paragraph .strong {
    font-size: 1.5em;
    font-weight: bold;
    color: #007bff; /* Make the important text more prominent */
}

</style>
