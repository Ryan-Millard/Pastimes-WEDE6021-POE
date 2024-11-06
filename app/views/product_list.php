<div class="container" id="<?= $containerId ?>">
	<div class="centered-text">
		<?php if(!empty($productListHeading)): ?>
			<h1><?= htmlspecialchars($productListHeading); ?></h1>

		<?php else: ?>
			<h1>Products</h1>
		<?php endif; ?>
	</div>

	<?php if(!empty($products)): ?>
		<div class="flex-evenly">
			<?php for($i = 0; $i < count($products); $i++): ?>
				<?php
					$product = $products[$i];
					$image = !empty($images[$i]) ? $images[$i] : 'default.jpg';

					include __DIR__ . '/shared/product_card.php';
				?>
			<?php endfor; ?>
		</div>

	<?php elseif (isset($noProductFoundMessage)): ?>
		<p><?= htmlspecialchars($noProductFoundMessage); ?></p>

	<?php else: ?>
		<p>No products found.</p>
	<?php endif; ?>
</div>
