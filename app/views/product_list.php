<div class="container" id="<?= $containerId ?? '' ?>">
	<div class="centered-text">
		<?php if(!empty($productListHeading)): ?>
			<h1><?= htmlspecialchars($productListHeading); ?></h1>

		<?php elseif(!isset($noProductListHeading)): ?>
			<h1>Products</h1>
		<?php endif; ?>
	</div>

	<?php if(!empty($products)): ?>
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
</style>
