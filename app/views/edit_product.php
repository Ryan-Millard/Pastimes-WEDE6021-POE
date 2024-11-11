<?php if (!empty($product) && !empty($username)): ?>
    <img
        class="custom-image"
        src="/pastimes/images/products/<?= htmlspecialchars($image ? $image : 'default.jpg'); ?>"
        alt="<?= htmlspecialchars($image); ?>"
    >
	<form action="/pastimes/admin/products/updateProduct/<?= htmlspecialchars($product['product_id']) ?>" method="post">
		<table class="product-table">
			<tr>
				<th>Product Name</th>
				<td class="no-padding">
					<label for="product_name"></label>
					<input type="text" name="product_name" class="edit-field" value="<?= htmlspecialchars($product['product_name']) ?>">
				</td>
			</tr>
			<tr>
				<th>Condition</th>
				<td>
					<label for="product_condition"></label>
					<select id="product_condition" name="product_condition" required>
						<option value="new" <?= htmlspecialchars($product['product_condition']) === 'new' ? 'selected' : '' ?>>New</option>
						<option value="used" <?= htmlspecialchars($product['product_condition']) === 'used' ? 'selected' : '' ?>>Used</option>
						<option value="refurbished" <?= htmlspecialchars($product['product_condition']) === 'refurbished' ? 'selected' : '' ?>>Refurbished</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Price (R)</th>
				<td>
					<div class="quantity-container">
						<button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
						<input type="number" name="price" id="quantity" value="<?= htmlspecialchars($product['price']) ?>" min="1" style="width: 50px; text-align: center;">
						<button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
					</div>
				</td>
			</tr>
			<tr>
				<th>Category</th>
				<td>
					<label for="product_category"></label>
					<select id="product_category" name="product_category" required>
						<option value="Men's Clothing" <?= $category['category_name'] === "Men's Clothing" ? 'selected' : '' ?>>Men's Clothing</option>
						<option value="Women's Clothing" <?= $category['category_name'] === "Women's Clothing" ? 'selected' : '' ?>>Women's Clothing</option>
						<option value="Children's Clothing" <?= $category['category_name'] === "Children's Clothing" ? 'selected' : '' ?>>Children's Clothing</option>
						<option value="Vintage Clothing" <?= $category['category_name'] === "Vintage Clothing" ? 'selected' : '' ?>>Vintage Clothing</option>
						<option value="Designer Clothing" <?= $category['category_name'] === "Designer Clothing" ? 'selected' : '' ?>>Designer Clothing</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Available Quantity</th>
				<td>
					<span class="display-value" id="productQuantity"><?= htmlspecialchars($product['quantity_available']); ?></span>
				</td>
			</tr>
			<tr>
				<th>Sold By</th>
				<td>
					<span class="display-value" id="soldBy"><?= htmlspecialchars($username); ?></span>
				</td>
			</tr>
			<tr>
				<th>Seller Rating</th>
				<td>
					<?php if (!empty($seller_rating)): ?>
						<span class="display-value" id="sellerRating"><?= htmlspecialchars($seller_rating); ?>/5</span>
					<?php else: ?>
						<?= 'Not found' ?>
					<?php endif; ?>
				</td>
			</tr>
		</table>

		<div class="display-flex action-container">
			<button class="btn approve-btn" type="submit" name="approve" value="1">Update & Approve Product</button>
			<button class="btn reject-btn" type="submit" name="approve" value="0">Reject Product</button>
		</div>
	</form>

<?php else: ?>
    <p>No product found.</p>
<?php endif; ?>

<?php require_once 'shared/flash_message.php'; ?>

<script>
    function toggleEdit(fieldId) {
        var displayValue = document.getElementById(fieldId);
        var editField = document.getElementById("edit" + fieldId.charAt(0).toUpperCase() + fieldId.slice(1));

        if (displayValue.style.display === "none") {
            displayValue.style.display = "inline";
            editField.style.display = "none";
        } else {
            displayValue.style.display = "none";
            editField.style.display = "inline";
        }
    }

    function changeQuantity(amount) {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = currentQuantity + amount;

        if (!isNaN(currentQuantity) && newQuantity >= 1) {
		console.log(newQuantity);
            quantityInput.value = newQuantity;
        }
    }
</script>


<style>
    .edit-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: #007bff;
    }

    .edit-btn:hover {
        color: #0056b3;
    }

    .edit-field {
		width: calc( fit-content );
		border: none;
		background: none;
		text-align: center;
		border-bottom: 1px solid #bbb;
    }
	.edit-field:focus {
    outline: none;
}

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
	  display: flex;               /* Activates flexbox layout */
	  justify-content: center;      /* Horizontally centers elements */
	  align-items: center;          /* Vertically centers elements */
	
		* {
			margin: 5px;
		}
    }

    .quantity-btn {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
		padding: 0px 50px;
    }

    .quantity-btn:hover {
        background-color: #0056b3;
    }

    input[type="number"] {
        width: 60px;
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

/* Action column styling */
table.product-table td:last-child {
    text-align: center;
    vertical-align: middle; /* Aligns buttons vertically */
}

body {
    background-color: #f8f8f8;
    color: #333;
    font-size: 16px;
    line-height: 1.6;
	margin: 2%;
}

/* Approve Button */
.edit-btn {
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: 0.3s;
}

.edit-btn:hover {
	transform: scale(1.5);
}

.display-flex {
	display: flex;
	justify-content: space-evenly;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .quantity-container {
            flex-direction: column;
        }

        .quantity-btn {
            width: 100%;
            padding: 10px;
        }
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

.action-container {
	margin-top: 10px;
}

.no-padding {
	padding: 0;
}
</style>
