<?php if(!empty($products)): ?>
	<?php for($i = 0; $i < count($products); $i++): ?>
		<?php
			$product = $products[$i];
			$image = !empty($images[$i]) ? $images[$i] : 'default.jpg';
		?>
		<a href="/pastimes/products/<?= htmlspecialchars($product['product_id']); ?>">
			<div>
				<?php if(!empty($image)): ?>
					<img
						class="custom-image"
						src="/pastimes/images/products/<?= htmlspecialchars($image); ?>"
						alt="<?= htmlspecialchars($image); ?>"
					>
				<?php else: ?>
					<?= 'Image Not found'; ?>
				<?php endif; ?>
			</div>
				<p>
					<?= strlen(htmlspecialchars($product['product_name'])) > 25 ?
								substr(htmlspecialchars($product['product_name']), 0, 30) . '...'
								:
								htmlspecialchars($product['product_name'])
					?>
					(<?= htmlspecialchars($product['product_condition']); ?>)
					R <?= htmlspecialchars($product['price']); ?>
				</p>
		</a>
	<?php endfor; ?>
<?php else: ?>
	<p>No products found.</p>
<?php endif; ?>
<style>
    .custom-image {
        height: 200px;
    }
</style>
