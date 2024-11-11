<?php if (!empty($product) && !empty($username)): ?>
	<img
		class="custom-image"
		src="/pastimes/images/products/<?= htmlspecialchars($image ? $image : 'default.jpg'); ?>"
		alt="<?= htmlspecialchars($image); ?>"
	>
    <table class="product-table">
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
            <th>Category</th>
            <td>
                <a class="category-link" href="/pastimes/categories/<?= $category['category_id'] ?>">
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
                <?php if (!empty($seller_rating)): ?>
                    <?= htmlspecialchars($seller_rating); ?>/5
                <?php else: ?>
                    <?= 'Not found' ?>
                <?php endif; ?>
            </td>
        </tr>
		<?php if ($user_is_buyer): ?>
			<tr>
				<th>Action</th>
				<td>
					<div class="wishlist-actions">
						<form action="/pastimes/products/<?= $product['product_id'] ?>" method="POST">
							<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">
							<div class="quantity-container">
								<button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
								<input type="number" name="quantity" id="quantity" value="<?= $quantity ?>" min="1" style="width: 50px; text-align: center;">
								<button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
								<input type="hidden" name="action" value="add_to_wishlist">
								<button class="btn add-to-wishlist" type="submit">Add</button>
							</div>
						</form>

					<!-- If the item exists in the wishlist (given by the wishlist quantity variable being truthy)-->
					<?php if ($quantity): ?>
							<form action="/pastimes/products/<?= $product['product_id'] ?>" method="POST">
								<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">
								<input type="hidden" name="action" value="remove_from_wishlist">
								<button class="btn remove-from-wishlist" type="submit">Remove</button>
							</form>
					<?php endif; ?>
					</div>
				</td>
			</tr>
		<?php elseif (isset($_SESSION['admin']) && $product['product_status'] === 'pending'): ?>
			<tr>
				<th>Action</th>
				<td>
					<div class="display-flex">
						<form action="/pastimes/admin/products/updateStatus" method="post" class="display-flex">
							<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">
							<input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id); ?>">
							<div>
								<button class="btn approve-btn" type="submit" name="approve" value="1">Approve Product</button>
							</div>

							<div>
								<button class="btn reject-btn" type="submit" name="approve" value="0">Reject Product</button>
							</div>
						</form>

						<a href="/pastimes/admin/products/editProduct/<?= htmlspecialchars($product['product_id']) ?>">
							<button class="btn edit-btn">Edit Product</button>
						</a>
					</div>
				</td>
			</tr>
		<?php endif; ?>
    </table>
<?php else: ?>
    <p>No product found.</p>
<?php endif; ?>

<?php require_once 'shared/flash_message.php'; ?>

<script>
    const maxQuantity = <?= htmlspecialchars($product['quantity_available']); ?>;

    function changeQuantity(amount) {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = currentQuantity + amount;

        if (!isNaN(currentQuantity) && newQuantity >= 1 && newQuantity <= maxQuantity) {
            quantityInput.value = newQuantity;
        }
    }
</script>

<style>
    table.product-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e2e2e2;
    }

    th {
        background-color: #f4f4f4;
        font-size: 16px;
        font-weight: 600;
    }

    td {
        font-size: 14px;
    }

    tr:hover {
        background-color: #fafafa;
    }

/* Style for the custom image */
.custom-image {
    height: 25em;
    width: auto; /* Maintain aspect ratio */
    max-width: 100%; /* Ensure it doesn't overflow */
    margin: 0 auto; /* Centers the image horizontally */
    display: block; /* Makes the image a block-level element */
    object-fit: contain; /* Ensures the image fits within the container while maintaining aspect ratio */
}

    /* Category Link */
    .category-link {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .category-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Button Styles */
    .btn {
        background-color: #007bff;
        color: #fff;
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

    /* Quantity Input */
    .quantity-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 4px;
        border-radius: 5px;
        cursor: pointer;
    }

    .quantity-btn:hover {
        background-color: #0056b3;
    }

    input[type="number"] {
        width: 60px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        table.product-table {
            font-size: 12px;
        }

        .quantity-container {
            flex-direction: column;
        }

        .quantity-btn {
            width: 100%;
            padding: 10px;
        }
    }

.wishlist-actions {
	display: flex;
}

/* Action column styling */
table.product-table td:last-child {
    text-align: center;
    vertical-align: middle; /* Aligns buttons vertically */
}

.wishlist-actions {
    display: flex;
    flex-direction: column; /* Stack the buttons vertically */
    gap: 10px; /* Space between buttons */
}

.wishlist-actions form {
    width: 100%;
    display: flex;
    justify-content: center; /* Center the buttons horizontally */
}

.wishlist-actions .btn {
    width: auto; /* Set the width to auto for buttons */
    padding: 10px 20px; /* Adjust button padding */
    text-align: center;
}

/* Style for buttons in wishlist actions */
.wishlist-actions button {
    width: 100%; /* Make buttons span full width on smaller screens */
    max-width: 200px; /* Limit the button width */
    padding: 12px 20px;
    text-align: center;
}

.wishlist-actions .quantity-container {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: center; /* Center quantity controls horizontally */
}

/* Responsive Design */
@media (max-width: 768px) {
    .wishlist-actions {
        flex-direction: column; /* Stack buttons vertically */
    }

    .wishlist-actions button {
        width: 100%; /* Full width on mobile */
    }
}

body {
    background-color: #f8f8f8;
    color: #333;
    font-size: 16px;
    line-height: 1.6;
	margin: 2%;
}

/* Approve Button */
.approve-btn {
    background-color: #28a745; /* Green color for approval */
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
margin-right: 10px;
}

.approve-btn:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Reject Button */
.reject-btn {
    background-color: #dc3545; /* Red color for rejection */
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.reject-btn:hover {
    background-color: #c82333; /* Darker red on hover */
}

/* Approve Button */
.edit-btn {
    background-color: #007bff; /* Green color for approval */
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.edit-btn:hover {
    background-color: #0056b3; /* Darker green on hover */
}

.display-flex {
	display: flex;
	justify-content: space-evenly;
}
</style>

