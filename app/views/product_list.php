<div class="container" id="<?= $containerId ?? '' ?>">
	<div class="centered-text">
		<?php if(!empty($productListHeading)): ?>
			<h1><?= htmlspecialchars($productListHeading); ?></h1>

		<?php elseif(!isset($noProductListHeading)): ?>
			<h1>Products</h1>
		<?php endif; ?>
	</div>

	<?php if(!empty($products)): ?>

		<!-- If there are products and the user is a buyer -->
		<?php if(in_array('buyer', $_SESSION['user']['user_roles'])): ?>
				<form action="/pastimes/dashboard#wishlist" method="post" class="text-center">
					<input type="hidden" name="action" value="empty_wishlist">
					<button class="btn remove-from-wishlist" type="submit">Empty Wishlist</button>
				</form>
		<?php endif; ?>

		<div class="flex-evenly">
			<?php for($i = 0; $i < count($products); $i++): ?>
				<?php
					$product = $products[$i];
					$image = !empty($images[$i]) ? $images[$i] : 'default.jpg';

					$quantity = 0;
					if(isset($quantities))
						$quantity = $quantities[$i];

					include __DIR__ . '/shared/product_card.php';
				?>
			<?php endfor; ?>
		</div>

	<?php elseif (isset($noProductFoundMessage)): ?>
		<p class="text-center"><?= htmlspecialchars($noProductFoundMessage); ?></p>

	<?php else: ?>
		<p class="text-center">No products found.</p>
	<?php endif; ?>
</div>

<style>
.flex-evenly {
	display: flex;
	justify-content: space-evenly;
    flex-wrap: wrap;
}

.text-center {
	text-align: center;
}
    /* Button Styles */
    .btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-align: center;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn.remove-from-wishlist {
        background-color: #dc3545;
    }

    .btn.remove-from-wishlist:hover {
        background-color: #c82333;
    }

</style>
