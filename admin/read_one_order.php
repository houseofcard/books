<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once '../objects/order.php';
include_once '../objects/order_item.php';
include_once "../objects/category.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$order = new Order($db);
$order_item = new OrderItem($db);
$category = new Category($db);

// set page title
$page_title = "Order Details";

// include page header HTML
include_once "layout_head.php";

// count pending orders
$pending_orders_count=$order->countPending();

// read order details based on given id
$transaction_id=isset($_GET['transaction_id']) ? $_GET['transaction_id'] : "";
$order->transaction_id=$transaction_id;
$order->readOneByTransactionId();

// check if record exists
if($order->created){
	
	// read order details
?>
	<a href='read_orders.php' class='btn btn-primary pull-right'>
		<span class='glyphicon glyphicon-list'></span>  Back to Orders
	</a>
	
	<h3><b>Order Summary</b></h3>

	<table class='table table-hover table-responsive table-bordered'>

		<tr>
			<td><b>Transaction ID</b></td>
			<td><?php echo $transaction_id; ?></td>
		</tr>
		<tr>
			<td><b>Transaction Date</b></td>
			<td><?php echo $order->created; ?></td>
		</tr>
		<tr>
			<td><b>Customer Name</b></td>
			<td><?php echo $order->firstname . " " . $order->lastname; ?></td>
		</tr>
		<tr>
			<td><b>Total Cost</b></td>
			<td>&#36;<?php echo number_format($order->total_cost, 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td><b>Payment Method</b></td>
			<td>
			<?php
				echo $order->from_paypal=="1" ? "PayPal" : "Bank Transfer";
			?>
			</td>
		</tr>
		<tr>
			<td><b>Status</b></td>
			<td>
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default <?php echo $order->status=='Pending Reconciliation' ? 'active' : ''; ?>">
						<input type="radio" name="status" value="Pending Reconciliation"
						transaction-id="<?php echo $transaction_id; ?>" <?php echo $order->status=='Pending Reconciliation' ? 'checked' : ''; ?>> Pending Reconciliation
					</label>

					<label class="btn btn-default <?php echo $order->status=='Payment Reconciled' ? 'active' : ''; ?>">
						<input type="radio" name="status" value="Payment Reconciled"
						transaction-id="<?php echo $transaction_id; ?>" <?php echo $order->status=='Payment Reconciled' ? 'checked' : ''; ?>> Payment Reconciled
					</label>

					<label class="btn btn-default <?php echo $order->status=='Completed' ? 'active' : ''; ?>">
						<input type="radio" name="status" value="Completed"
						transaction-id="<?php echo $transaction_id; ?>" <?php echo $order->status=='Completed' ? 'checked' : ''; ?>> Items Sent / Order Completed
					</label>
						
					<label class="btn btn-default <?php echo $order->status=='Cancelled' ? 'active' : ''; ?>">
						<input type="radio" name="status" value="Cancelled"
						transaction-id="<?php echo $transaction_id; ?>" <?php echo $order->status=='Cancelled' ? 'checked' : ''; ?>> Cancelled
					</label>
				</div>
			</td>
		</tr>
	</table>

	<h3><b>Order Items</b></h3>
	<?php

	// retrieve order items
	$order_item->transaction_id=$transaction_id;
	$stmt=$order_item->readAll();

	echo "<div class='table-responsive'>";
		echo "<table class='table table-hover table-bordered'>";
		
			// our table heading
			echo "<tr>";
				echo "<td class='textAlignLeft'><b>Product Name</b></td>";
				echo "<td><b>Price (NZD)</b></td>";
				echo "<td><b>Quantity</b></td>";
				echo "<td><b>Subtotal</b></td>";
			echo "</tr>";

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				//creating new table row per record
				echo "<tr>";
					echo "<td>{$product_name} ({$variation_name})</td>";
					echo "<td>&#36;" . number_format($price, 2, '.', ',') . "</td>";
					echo "<td>{$quantity}</td>";
					echo "<td>";
						echo "&#36;" . number_format($price*$quantity, 2, '.', ',');
					echo "</td>";
				echo "</tr>";
			}

			// order total cost
			echo "<tr>";
				echo "<td><b>Total Cost</b></td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td><b>&#36;" . number_format($order->total_cost, 2, '.', ',') . "</b></td>";
			echo "</tr>";
	
		echo "</table>";
	echo "<div>";
}

// tell the user that the order does not exist
else{
	echo "<p>Order does not exist.</p>";
}

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>
