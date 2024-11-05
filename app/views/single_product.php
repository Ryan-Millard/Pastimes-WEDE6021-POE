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
				<div class="category-link-container">
					<a class="category-link" href="/pastimes/categories/<?= $category['category_id'] ?>">
						<?= htmlspecialchars($category['category_name']); ?>
					</a>
				</div>
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
			<form action="/pastimes/products/<?= $product['product_id'] ?>" method="POST">
					<input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">

					<div class="centered-content">
						<label for="quantity">Quantity:</label>
						<div class="quantity-container">
							<button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
							<input type="number" name="quantity" id="quantity" value="1" min="1" style="width: 50px; text-align: center;">
							<button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
						</div>

						<button type="submit">Add to Wishlist</button>
					</div>
				</form>
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

<script>
const maxQuantity = <?= htmlspecialchars($product['quantity_available']); ?>; // Pass the available quantity to JavaScript

function changeQuantity(amount) {
    var quantityInput = document.getElementById('quantity');
    var currentQuantity = parseInt(quantityInput.value);
    var newQuantity = currentQuantity + amount;

    // Ensure newQuantity is within the allowed limits
    if (!isNaN(currentQuantity) && newQuantity >= 1 && newQuantity <= maxQuantity) {
        quantityInput.value = newQuantity; // Update input value
    }
}
</script>


<style>
/* Style for the table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px; /* Add space above the table */
}

/* Style for table headers */
th {
    text-align: left;
    background-color: #f2f2f2;
    padding: 10px;
    border-bottom: 2px solid #ddd; /* Adds a bottom border for separation */
}

/* Style for table data cells */
td {
    padding: 10px;
    border-bottom: 1px solid #ddd; /* Adds a bottom border to each row */
}

/* Hover effect for table rows */
tr:hover {
    background-color: #f9f9f9; /* Light grey background on hover */
}

/* Style for the custom image */
.custom-image {
    height: 200px;
    width: auto; /* Maintain aspect ratio */
    max-width: 100%; /* Ensure it doesn't overflow */
}

/* Button styles */
button {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    border: none;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px; /* Larger text for the button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

/* Button hover effect */
button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

/* Responsive adjustments */
@media (max-width: 600px) {
    th, td {
        padding: 8px; /* Slightly smaller padding for mobile */
        font-size: 14px; /* Smaller text for mobile */
    }

    button {
        width: 100%; /* Full-width button on mobile */
    }
}

/* Style for the category name link */
.category-link {
    color: #007bff; /* Bootstrap primary color for links */
    text-decoration: none; /* Remove underline */
    font-weight: bold; /* Make the text bold */
    transition: color 0.3s ease; /* Smooth transition for hover effect */
}

/* Hover effect for the category link */
.category-link:hover {
    color: #0056b3; /* Darker shade on hover */
    text-decoration: underline; /* Underline on hover for emphasis */
}

/* Style for the category link container */
.category-link-container {
    display: inline-block; /* Align properly */
    padding: 5px 10px; /* Add padding for better click area */
    border-radius: 5px; /* Rounded corners for better aesthetics */
    background-color: #DDDDDD; /* Light background for the link container */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

/* Hover effect for the category link container */
.category-link-container:hover {
    background-color: #e2e6ea; /* Darker background on hover */
}

.quantity-container {
    display: flex;
    align-items: center;
	margin-bottom: 5px;
}

.quantity-btn {
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    border: none;
    padding: 4px 9px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px; /* Larger text for the button */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
}

.quantity-btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

input[type="number"] {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin: 0 5px; /* Add space between buttons and input */
}

.centered-content {
    display: flex; /* Enables Flexbox layout */
    flex-direction: column; /* Arranges children in a column */
    align-items: center; /* Centers children horizontally */
    justify-content: center; /* Centers children vertically */
	width: fit-content;
}
</style>

