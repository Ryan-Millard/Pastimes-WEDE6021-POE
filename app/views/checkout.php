<?php
	$total = 0;
?>

<div class="checkout-container">
	<h1>Checkout</h1>

	<form action="/pastimes/checkout" method="post">
		<!-- User Details Form -->
		<section class="user-details">
			<h2>Billing Information</h2>
				<label for="full-name">Full Name</label>
				<input type="text" id="full-name" name="full_name" required>
				
				<label for="email">Email Address</label>
				<input type="email" id="email" name="email" required>
				
				<label for="address">Shipping Address</label>
				<textarea id="address" name="address" required></textarea>
				
				<label for="phone">Phone Number</label>
				<input type="tel" id="phone" name="phone" required>
		</section>
		
		<!-- Items Summary -->
		<section class="items-summary">
			<h2>Your Order</h2>
			<table>
				<thead>
					<tr>
						<th>Images</th>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>

					<?php for($i = 0; $i < count($products); $i++): ?>
						<?php
							$subTotal = htmlspecialchars($products[$i]['price']) * htmlspecialchars($wishlist[$i]['quantity']);
							$total += $subTotal;
						?>
						<tr>
							<td><img class="checkout-image" src="/pastimes/images/products/<?= htmlspecialchars($images[$i]) ?>" alt="<?= htmlspecialchars($images[$i]) ?>"></td>
							<td><?= htmlspecialchars($products[$i]['product_name']) ?></td>
							<td><?= htmlspecialchars($products[$i]['price']) ?></td>
							<td><?= htmlspecialchars($wishlist[$i]['quantity']) ?></td>
							<td><?= $subTotal ?></td>
						</tr>
					<?php endfor; ?>

				</tbody>
			</table>
			<p class="total-price">Total: $<?= $total ?></p>
			<input type="hidden" id="total_price" name="total_price" value="<?= $total ?>">
		</section>
		
		<!-- Payment Information -->
		<section class="payment">
			<h2>Payment Method</h2>
			<label for="payment-method">Choose a payment method</label>
			<select id="payment-method" name="payment_method" required>
				<option value="" disabled selected>Select an option</option>
				<option value="Credit Card">Credit Card</option>
				<option value="PayPal">PayPal</option>
				<option value="Bank Transfer">Bank Transfer</option>
			</select>

			<div id="credit-card-info" class="payment-info">
				<label for="card-number">Card Number</label>
				<input type="text" id="card-number" name="card_number" placeholder="1234 5678 9101 1121" required>

				<label for="expiry-date">Expiry Date</label>
				<input type="month" id="expiry-date" name="expiry_date" required>

				<label for="cvv">CVV</label>
				<input type="text" id="cvv" name="cvv" placeholder="123" required>
			</div>

			<div id="paypal-info" class="payment-info" style="display: none;">
				<label for="paypal-email">PayPal Email</label>
				<input type="email" id="paypal-email" name="paypal_email" placeholder="your-email@paypal.com" required>
			</div>

			<div id="bank-info" class="payment-info" style="display: none;">
				<label for="bank-account">Bank Account Number</label>
				<input type="text" id="bank-account" name="bank_account" placeholder="123-456-789" required>
			</div>
		</section>

		<!-- Checkout Button -->
		<button type="submit" class="checkout-btn">Proceed to Payment</button>
	</form>
</div>

<script>
document.getElementById('payment-method').addEventListener('change', function() {
    var selectedMethod = this.value;

    // Hide and disable all payment information fields initially
    document.querySelectorAll('.payment-info').forEach(function(info) {
        info.style.display = 'none';  // Hide all payment sections
        info.querySelectorAll('input').forEach(function(input) {
            input.disabled = true;  // Disable all input fields
        });
    });

    // Show and enable the selected payment method's fields
    if (selectedMethod === 'credit-card') {
        var creditCardInfo = document.getElementById('credit-card-info');
        creditCardInfo.style.display = 'block';  // Show credit card section
        creditCardInfo.querySelectorAll('input').forEach(function(input) {
            input.disabled = false;  // Enable all inputs in this section
        });
    } else if (selectedMethod === 'paypal') {
        var paypalInfo = document.getElementById('paypal-info');
        paypalInfo.style.display = 'block';  // Show PayPal section
        paypalInfo.querySelectorAll('input').forEach(function(input) {
            input.disabled = false;  // Enable all inputs in this section
        });
    } else if (selectedMethod === 'bank-transfer') {
        var bankInfo = document.getElementById('bank-info');
        bankInfo.style.display = 'block';  // Show bank transfer section
        bankInfo.querySelectorAll('input').forEach(function(input) {
            input.disabled = false;  // Enable all inputs in this section
        });
    }
});


	// Script to show the relevant payment information based on the selected method
	document.getElementById('payment-method').addEventListener('change', function() {
		var selectedMethod = this.value;
		document.querySelectorAll('.payment-info').forEach(function(info) {
			info.style.display = 'none';
		});
		if (selectedMethod === 'credit-card') {
			document.getElementById('credit-card-info').style.display = 'block';
		} else if (selectedMethod === 'paypal') {
			document.getElementById('paypal-info').style.display = 'block';
		} else if (selectedMethod === 'bank-transfer') {
			document.getElementById('bank-info').style.display = 'block';
		}
	});
</script>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.checkout-container {
    width: 70%;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #333;
}

h1 {
    font-size: 32px;
    margin-bottom: 20px;
}

/* Form Fields */
form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
}

form input, form textarea, form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

form input[type="text"],
form input[type="email"],
form input[type="tel"],
form input[type="month"] {
    font-size: 16px;
}

form textarea {
    font-size: 16px;
    height: 100px;
}

form select {
    font-size: 16px;
}

/* Items Summary Table */
.items-summary table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.items-summary th, .items-summary td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

.items-summary th {
    background-color: #f8f8f8;
    font-weight: bold;
}

.items-summary td {
    background-color: #fff;
}

.items-summary .total-price {
    font-size: 20px;
    font-weight: bold;
    text-align: right;
    margin-top: 10px;
}

/* Payment Section */
.payment {
    margin-top: 30px;
}

.payment label {
    font-weight: bold;
}

.payment select {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.payment-info {
    margin-top: 15px;
    display: none;
}

.payment-info input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Checkout Button */
.checkout-btn {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.checkout-btn:hover {
    background-color: #45a049;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .checkout-container {
        width: 90%;
    }
}

@media (max-width: 480px) {
    .checkout-container {
        width: 100%;
        padding: 15px;
    }

    .checkout-btn {
        font-size: 16px;
    }
}

.checkout-image {
    width: 60px; /* Set a larger width for the images */
    height: auto; /* Maintain the aspect ratio */
    object-fit: contain; /* Ensure the image fits within the given size without distortion */
    border-radius: 4px; /* Optionally add rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle shadow for a polished look */
    margin: 0 auto; /* Center the images within the table cell */
    display: block;
}

</style>
