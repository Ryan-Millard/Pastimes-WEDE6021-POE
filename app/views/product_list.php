<div class="container">
	<?php if(!empty($products)): ?>
		<?php for($i = 0; $i < count($products); $i++): ?>
			<?php
				$product = $products[$i];
				$image = !empty($images[$i]) ? $images[$i] : 'default.jpg';
			?>
			<a href="/pastimes/products/<?= htmlspecialchars($product['product_id']); ?>" class="product-link">
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
				<div class="product-details">
					<p class="product-name">
						<?= strlen(htmlspecialchars($product['product_name'])) > 25 ?
									substr(htmlspecialchars($product['product_name']), 0, 30) . '...'
									:
									htmlspecialchars($product['product_name'])
						?>
						(<?= htmlspecialchars($product['product_condition']); ?>)
						<p class="product-price">R <?= htmlspecialchars($product['price']); ?></p>
					</p>
				</div>
			</a>
		<?php endfor; ?>
	<?php else: ?>
		<p>No products found.</p>
	<?php endif; ?>
</div>

<style>
/* Product Link */
.product-link {
    display: inline-block;
    text-decoration: none;
    color: #333;
    margin: 15px;
    max-width: 200px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-link:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Product Image */
.custom-image {
    height: 200px;
    width: 100%;
    object-fit: cover;
    border-radius: 8px;
}

/* Product Details */
.product-details {
    margin-top: 10px;
    font-size: 1rem;
    color: #555;
}

/* Product Name */
.product-name {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Product Price */
.product-price {
    color: #007BFF;
    font-weight: bold;
}

</style>


<style>
    .custom-image {
        height: 200px;
    }
</style>
