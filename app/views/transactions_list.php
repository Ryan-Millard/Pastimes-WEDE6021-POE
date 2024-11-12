<?php
	$total = 0;
?>
<h1>Purchase History</h1>

<div class="transaction-table-container">
    <table>
        <thead>
            <tr>
                <th>Reference Number</th>
                <th>Transaction Date & Time</th>
                <th>Shipping Address</th>
                <th>Payment Method</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
			<?php foreach($purchases as $purchase): ?>
				<?php
					$url = '/pastimes/purchases/' . $purchase['transaction_id'];
					$total += $purchase['total_price'];
				?>
				<tr onclick="window.location='<?= $url ?>';" style="cursor: pointer;">
					<td><?= $purchase['reference_number'] ?></td>
					<td><?= $purchase['transaction_datetime'] ?></td>
					<td><?= $purchase['shipping_address'] ?></td>
					<td><?= $purchase['payment_method'] ?></td>
					<td><?= $purchase['total_price'] ?></td>
				</tr>
			<?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>

<style>

.transaction-table-container {
    width: fit-content;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
}

td {
    background-color: #fff;
}

/* Zebra Striping for Rows */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .transaction-table-container {
        width: 90%;
    }
}

@media (max-width: 480px) {
    .transaction-table-container {
        width: 100%;
        padding: 15px;
    }
}
tr:hover td {
    background-color: #f1f1f1;
}

</style>
