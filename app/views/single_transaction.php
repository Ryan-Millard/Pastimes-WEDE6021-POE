<?php
    $total = 0;
?>

<div class="transaction-info">
    <h2>Transaction Details</h2>
    <p><strong>Transaction ID:</strong> <?= $transaction['transaction_id'] ?></p>
    <p><strong>Transaction Date and Time:</strong> <?= $transaction['transaction_datetime'] ?></p>
    <p><strong>Total Price:</strong> $<?= number_format($transaction['total_price'], 2) ?></p>
    <p><strong>Shipping Address:</strong> <?= htmlspecialchars($transaction['shipping_address']) ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($transaction['payment_method']) ?></p>
    <p><strong>Reference Number:</strong> <?= htmlspecialchars($transaction['reference_number']) ?></p>
</div>

<section class="items-summary">
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
					$subTotal = (int)htmlspecialchars($products[$i]['price']) * (int)htmlspecialchars($transactionProducts[$i]['quantity']);
					$total += $subTotal;
					$productUrl = "/pastimes/products/{$products[$i]['product_id']}";
				?>
				<tr onclick="window.location='<?= $productUrl ?>';" style="cursor: pointer;">
					<td><img class="checkout-image" src="/pastimes/images/products/<?= htmlspecialchars($images[$i]) ?>" alt="<?= htmlspecialchars($images[$i]) ?>"></td>
					<td><?= htmlspecialchars($products[$i]['product_name']) ?></td>
					<td>$<?= number_format($products[$i]['price'], 2) ?></td>
					<td><?= htmlspecialchars($transactionProducts[$i]['quantity']) ?></td>
					<td>$<?= number_format($subTotal, 2) ?></td>
				</tr>
			<?php endfor; ?>


            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</section>

<style>
.checkout-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: block;
    margin: 0 auto;
}

.transaction-info {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.transaction-info h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.transaction-info p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 10px;
}

.transaction-info p strong {
    color: #333;
}

.items-summary table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.items-summary th, .items-summary td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 16px;
    color: #333;
}

.items-summary th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.items-summary td {
    background-color: #fff;
}

.items-summary tr:nth-child(even) td {
    background-color: #f9f9f9;
}

.items-summary tr:hover td {
    background-color: #f1f1f1;
}

.items-summary .total-row td {
    background-color: #e0e0e0;
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.items-summary .total-row td strong {
    font-size: 20px;
}

.text-right {
    text-align: right;
}

@media (max-width: 768px) {
    .items-summary table {
        font-size: 14px;
    }

    .checkout-image {
        width: 60px;
        height: 60px;
    }

    .transaction-info p {
        font-size: 14px;
    }
}
</style>

