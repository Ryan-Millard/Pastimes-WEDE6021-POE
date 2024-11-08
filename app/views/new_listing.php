 <div class="new-listing">
	<details>
	<br />
		<summary><h3>New Listing</h3></summary>
		<form action="/pastimes/addProduct" method="POST" enctype="multipart/form-data">
			<label for="image">Product Image:</label><br>
			<input type="file" id="image" name="image" for="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp" required><br><br>

			<label for="product_condition">Product Condition</label>
			<select id="product_condition" name="product_condition" required>
				<option value="new">New</option>
				<option value="used">Used</option>
				<option value="refurbished">Refurbished</option>
			</select>

			<label for="product_category">Product Category</label>
			<select id="product_category" name="product_category" required>
				<option value="Men's Clothing">Men's Clothing</option>
				<option value="Women's Clothing">Women's Clothing</option>
				<option value="Children's Clothing">Children's Clothing</option>
				<option value="Vintage Clothing">Vintage Clothing</option>
				<option value="Designer Clothing">Designer Clothing</option>
			</select>

			<label for="product_name">Product Name</label>
			<input type="text" id="product_name" name="product_name" maxlength="255" required>

			<label for="description">Description</label>
			<textarea id="description" name="description" rows="4"></textarea>

			<label for="price">Price</label>
			<input type="number" id="price" name="price" step="0.01" required>

			<label for="quantity_available">Quantity Available</label>
			<input type="number" id="quantity_available" name="quantity_available" required>

			<label for="size">Size (optional)</label>
			<input type="text" id="size" name="size" maxlength="50">

			<label for="color">Color (optional)</label>
			<input type="text" id="color" name="color" maxlength="50">

			<label for="brand">Brand (optional)</label>
			<input type="text" id="brand" name="brand" maxlength="100">

			<label for="material">Material (optional)</label>
			<input type="text" id="material" name="material" maxlength="100">

			<label for="tags">Tags (optional)</label>
			<textarea id="tags" name="tags" rows="2"></textarea>

			<button type="submit">Create Listing</button>
		</form>
	</details>
</div>

<style>
form {
    width: 600px;
    margin: auto;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input, select, textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    box-sizing: border-box;
}

form button {
    width: auto;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

form button:hover {
    background-color: #45a049;
}

/* .new-listing adjustments */
.new-listing {
    display: flex;
    justify-content: center; /* Centers the form horizontally */
    align-items: center; /* Centers the form vertically */
    padding: 20px; /* Adds some padding around the content */
}

details {
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: fit-content; /* Limits maximum width of the form */
	max-height: fit-content;
}

summary {
    list-style: none;
    cursor: pointer;
    text-align: center;
}

summary h3 {
    border-radius: 6px;
    color: white;
    background-color: #007BFF;
    display: inline-block;
    padding: 1% 1%;
    margin: 0;
    border: 2px solid #007BFF;
    transition: all 0.3s ease; /* Adds a smooth transition for all properties */
}

summary h3:hover {
    border: 2px solid #007BFF;
    color: #007BFF;
    background-color: white;
}

summary h3:active {
    border-radius: 6px;
    color: white;
    background-color: #007BFF;
    transition: all 0.3s ease; /* Ensure transition happens on click */
}

</style>
