<?php if(!empty($product) && !empty($username)): ?>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>Product Name</th>
			<td><?= htmlspecialchars($product['product_name']) ?></td>
		</tr>
		<tr>
			<th>Condition</th>
			<td><?= htmlspecialchars($product['product_condition']); ?></td>
		</tr>
		<tr>
			<th>Price</th>
			<td>R <?= htmlspecialchars($product['price']); ?></td>
		</tr>
		<tr>
			<th>Image</th>
			<td>
				<img
					class="custom-image"
					src="/pastimes/images/products/<?= htmlspecialchars($image ? $image : 'default.jpg'); ?>"
					alt="<?= htmlspecialchars($image); ?>"
				>
			</td>
		</tr>
		<tr>
			<th>Category</th>
			<td>
				<a href="/pastimes/categories/<?= $category['category_id'] ?>">
					<?= htmlspecialchars($category['category_name']); ?>
				</a>
			</td>
		</tr>
		<tr>
			<th>Available Quantity</th>
			<td><?= htmlspecialchars($product['quantity_available']); ?></td>
		</tr>
		<tr>
			<th>Sold By</th>
			<td><?= htmlspecialchars($username); ?></td>
		</tr>
		<tr>
			<th>Seller Rating</th>
			<td>
				<?php if(!empty($seller_rating)): ?>
					<?= htmlspecialchars($seller_rating); ?>/5
				<?php else: ?>
					<?= 'Not found' ?>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>Action</th>
			<td>
			<button onclick="showPopup('<?php echo 'Price R ' . $product['price']; ?>')">
					Add to Shopping Cart
				</button>
			</td>
		</tr>
	</table>
<?php else: ?>
	<p>No product found.</p>
<?php endif; ?>

<?php
	// use the flash_message popup
	require_once 'shared/flash_message.php';
?>

<style>
	.custom-image {
		height: 200px;
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}
	th {
		text-align: left;
		background-color: #f2f2f2;
	}
	th, td {
		padding: 10px;
	}
</style>

